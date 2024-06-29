<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\Visitor;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Jobs\SendMailjob;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function dashboard()
    {

        return view('dashboard');
    }

    public function index()
    {
        $staff = User::all();
        $user = Auth::user();

        if ($user->type == 'admin') {
            $data = Visitor::all();
        } else {
            $data = $user->visitors()->get();
        }

        $visitorpurpose = [
            'appointment' => 'Appointment',
            'interview' => 'Interview',
            'servicecall' => 'Servicecall',
            'clientcustomervisit' => 'Clientcustomervisit',
        ];
        return view('appointment.index', compact('staff', 'data', 'visitorpurpose'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            $errordata = [
                'error' => true,
                'errors' => $validator->errors(),
                'msg' => 'All fields required'
            ];
            return response()->json($errordata, 200);
        }
        if (isset($request->id) && !empty($request->id)) {
            $appointment = Visitor::where('id', $request->id)->first();
        } else {
            $appointment = new Visitor();
        }

        $updateQRCode = true;
        if ($request->has('visit_date') && !empty($request->visit_date)) {
            $visitDate = $request->visit_date;
            $visitDateRange = $appointment->visit_date;
            if (strpos($visitDateRange, ' to ') !== false && strpos($visitDate, ' to ') !== false) {
                list($dbStartDate, $dbEndDate) = explode(' to ', $visitDateRange);
                list($startDate, $endDate) = explode(' to ', $visitDate);
                $dbStartDate = Carbon::parse($dbStartDate);
                $dbEndDate = Carbon::parse($dbEndDate);
                $startDate = Carbon::parse($startDate);
                $endDate = Carbon::parse($endDate);
                if ($startDate->between($dbStartDate, $dbEndDate) && $endDate->between($dbStartDate, $dbEndDate)) {
                    $updateQRCode = false;
                } else {
                    $updateQRCode = true;
                }
            } else if (strpos($visitDateRange, ' to ') === false && strpos($visitDate, ' to ') === false) {
                $dbDate = Carbon::parse($visitDateRange);
                $newDate = Carbon::parse($visitDate);
                if ($newDate->eq($dbDate)) {
                    $updateQRCode = false;
                } else {
                    $updateQRCode = true;
                }
            }
        }
        if ($updateQRCode) {
            $this->updateappointmentQrcodevisitCode($appointment, $request);
        }

        $appointment->name = $request->name;
        $appointment->email = $request->email;

        if ($request->has('phone')) {
            $appointment->phone = $request->phone;
        }
        if ($request->has('visit_date')) {
            $appointment->visit_date = $request->visit_date;
        }
        if ($request->has('host_id')) {
            $appointment->host_id = $request->host_id;
        }
        if ($request->has('companyname')) {
            $appointment->companyname = $request->companyname;
        }
        if ($request->has('group_name')) {
            $appointment->group_name = $request->group_name;
        }
        if ($request->has('type')) {
            $appointment->type = $request->type;
        }
        if ($request->has('purpose')) {
            $appointment->purpose = $request->purpose;
        }



        $appointment->save();

        Session::flash('sa-success', 'appointment Added Successfully !!!');
        return redirect()->route('newappointment');
    }

    public function updateappointmentQrcodevisitCode($appointment, $request)
    {
        $appointment->name = $request->name;
        $appointment->email = $request->email;

        if ($request->has('phone')) {
            $appointment->phone = $request->phone;
        }
        if ($request->has('visit_date')) {
            $appointment->visit_date = $request->visit_date;
        }
        if ($request->has('host_id')) {
            $appointment->host_id = $request->host_id;
        }
        if ($request->has('companyname')) {
            $appointment->companyname = $request->companyname;
        }
        if ($request->has('group_name')) {
            $appointment->group_name = $request->group_name;
        }
        if ($request->has('type')) {
            $appointment->type = $request->type;
        }
        if ($request->has('purpose')) {
            $appointment->purpose = $request->purpose;
        }

        if(!empty($appointment)){
            $path = (array)$appointment->qr_code;
            if (isset($path[0]) && $path[0]) {
                $image_path = public_path($path[0]);
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        $code = random_int(1000, 9999);

        $baseUrl = 'http://127.0.0.1:8000/dashboard/appointmentdetails';
        $url = $baseUrl . '?code=' . $code;
        $qrCodeUrl = 'https://qrcode.tec-it.com/API/QRCode?data=' . $url;

        $qrCodeContent = file_get_contents($qrCodeUrl);

        $qrCodePath = 'uploads/qrcodes/visitor_' . $code . '.png';

        file_put_contents(public_path($qrCodePath), $qrCodeContent);

        $appointment->qr_code = $qrCodePath;
        $appointment->visit_code = $code;
        $appointment->save();

        $senddata['meetingDetails'] = [
            'id' => $appointment->id,
            'title' => 'Team Meeting',
            'recipient_name' => $request->name,
            'recipient_email' => $request->email,
            'date' => explode('to', $request->visit_date)[0],
            'time' => '10:00 AM',
            'location' => 'India, Vaishali',
            'agenda' => 'Discuss project milestones and deadlines',
            'sender_name' => Auth::user()->name,
            'sender_email' => Auth::user()->email,
        ];

        $companyLogoPath = public_path('assets/images/logo/Seser_logo_horizontal_purple.png');
        $companyLogoData = base64_encode(file_get_contents($companyLogoPath));
        $companyLogoUrl = 'data:image/png;base64,' . $companyLogoData;

        $qrPath = $qrCodePath;
        $qrData = base64_encode(file_get_contents($qrPath));
        $qrUrl = 'data:image/png;base64,' . $qrData;

        $rsvpYesUrl = url('/rsvp/' . $senddata['meetingDetails']['id'] . '/yes?email=' . urlencode($senddata['meetingDetails']['recipient_email']));
        $rsvpNoUrl = url('/rsvp/' . $senddata['meetingDetails']['id'] . '/no?email=' . urlencode($senddata['meetingDetails']['recipient_email']));
        $body = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Your Appointment</title>
            <style>
                    body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    background-color: #ffffff;
                    margin: 50px auto;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                }
                .header {
                    text-align: center;
                    border-bottom: 1px solid #dddddd;
                    padding-bottom: 20px;
                    margin-bottom: 20px;
                }
                .header img {
                    max-width: 150px;
                }
                h2 {
                    color: #4CAF50;
                    text-align: center;
                }
                .details {
                    margin-top: 20px;
                    width: 100%;
                    border-collapse: collapse;
                }
                .details th, .details td {
                    padding: 12px;
                    border: 1px solid #ccc;
                }
                .details th {
                    background-color: #f9f9f9;
                    text-align: left;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    color: #888888;
                }
                    .rsvp-buttons {
            text-align: center;
            margin-top: 20px;
        }
        .rsvp-buttons a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
        }
        .rsvp-yes {
            background-color: #4CAF50;
        }
        .rsvp-no {
            background-color: #f44336;
        }s
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <img src='{$companyLogoUrl}' alt='Company Logo'>
                </div>
                <h2>Appointment Details</h2>
                <p>Dear {$request->name},</p>
                <p>Your appointment details are as follows:</p>
                <table class='details'>
                    <tr>
                        <th>Appointment ID</th>
                        <td>{$senddata['meetingDetails']['id']}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{$senddata['meetingDetails']['title']}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{$senddata['meetingDetails']['date']}</td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td>{$senddata['meetingDetails']['time']}</td>
                    </tr> 
                    <tr>
                        <th>Location</th>
                        <td>{$senddata['meetingDetails']['location']}</td>
                    </tr>
                    <tr>
                        <th>Agenda</th>
                        <td>{$senddata['meetingDetails']['agenda']}</td>
                    </tr>
                    <tr>
                        <th>Sender Name</th>
                        <td>{$senddata['meetingDetails']['sender_name']}</td>
                    </tr>
                    <tr>
                        <th>Sender Email</th>
                        <td>{$senddata['meetingDetails']['sender_email']}</td>
                    </tr>
                   <tr>
                    <th>QR Code</th>
                <td><img src='{$qrUrl}' style='max-width: 150px; height: auto;' alt='QR Code'></td>
                </tr>
                   <tr>
                    <th>Visit Code</th>
                <td>{$code}</td>
                </tr>
                </table>
                 <p>Looking forward to your participation.</p>
                <p>Best regards,<br>{$senddata['meetingDetails']['sender_name']}</p>
                <p>To add this meeting to your calendar, please use the attached file.</p>
                <p>
                Please let us know if you will be attending:<br>
                 <div class='rsvp-buttons'>
            <a href='{$rsvpYesUrl}' class='rsvp-yes'>Yes, I will attend</a>
            <a href='{$rsvpNoUrl}' class='rsvp-no'>No, I cannot attend</a>
        </div>
            </p>
                <div class='footer'>
                <p>If you have any questions, please contact {$senddata['meetingDetails']['sender_name']} at <a href='mailto:{$senddata['meetingDetails']['sender_email']}'>{$senddata['meetingDetails']['sender_email']}</a>.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $senddata['email'] = 'himanshu@beaconcoders.com';
        $senddata['subject'] = 'Your Appointment Details';
        $senddata['body'] = $body;

        $senddata['attachedFile'] = null;
        // $senddata['attachedFile'] = public_path($qrCodePath);

        $senddata['headers'] = "MIME-Version: 1.0\r\n";
        $senddata['headers'] .= "Content-type: text/html; charset=UTF-8\r\n";

        $sendmailres = $this->sendmail($senddata);
    }

    public function getaptByid(Request $request)
    {

        $apt = Visitor::find($request->id);
        if ($apt) {
            // return json_encode($apt);
            return response()->json(['error' => false, 'message' => 'profile updated successfully', 'data' => $apt]);
        } else {
            return response()->json('data not found');
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        $aptid = Visitor::find($request->id);
        if (!$aptid) {
            $errordata = [
                'error' => true,
                'errors' => $validator->errors(),
                'msg' => 'ID Not Found',
            ];
            return response()->json($errordata, 200);
        } else {
            $aptid->delete();
            return response()->json("Appointment Deleted Successfully !");
        }
    }

    public function sendmail($request)
    {
        $data['mail'] = $request['email'];
        $data['subject'] = $request['subject'];
        $data['body'] = $request['body'];
        $data['attachedFile'] = $request['attachedFile'];
        $data['meetingDetails'] = $request['meetingDetails'];

        dispatch(new SendMailJob($data));
        return true;
    }
}
