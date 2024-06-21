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


class AppointmentController extends Controller
{
    public function dashboard()
    {
        
        // $data = [
        //     'mail' => 'hkushwaha066@gmail.com',
        //     'subject' => 'Meeting Invitation',
        //     'body' => 'You are invited to a meeting.',
        //     'attachedFile' => 'c:\Users\ABC\Downloads\Untitled design (25) (1).png', 
        //     'meetingDetails' => [
        //         'id' => 1,  // This should be the actual meeting ID from your database
        //         'title' => 'Team Meeting',
        //         'recipient_name' => 'John Doe',
        //         'recipient_email' => 'hkushwaha066@gmail.com',
        //         'date' => '2024-06-25',
        //         'time' => '10:00 AM',
        //         'location' => 'Conference Room A',
        //         'agenda' => 'Discuss project milestones and deadlines',
        //         'sender_name' => 'Jane Smith'
        //     ]
        // ];
        
        // $dd = dispatch(new SendMailjob($data));
        
        // if ($dd) {
        //     echo "send";
        // } else {
        //     echo "not send";
        // }
        // die("sdfsfsafsafas");

        return view('dashboard');
    }

    public function index()
    {
        $staff = User::all();
        $data = Visitor::all();

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
        $code = random_int(1000, 9999);

        $baseUrl = 'http://127.0.0.1:8000/dashboard/appointmentdetails'; 
        $url = $baseUrl . '?code=' . $code;
        $qrCodeUrl = 'https://qrcode.tec-it.com/API/QRCode?data=' . $url;

        $qrCodeContent = file_get_contents($qrCodeUrl);

        $qrCodePath = 'uploads/qrcodes/visitor_' . $code . '.png';

        file_put_contents(public_path($qrCodePath), $qrCodeContent);

        $appointment->qr_code = $qrCodePath;
        $appointment->visit_code = $code;

        
        $body = "
        <h2>Appointment </h2>
        <p>Dear $request->name,</p>";

        $email = 'himanshu@beaconcoders.com';
        $senddata['name'] = $request->name;
        $senddata['email'] = $email;
        $senddata['subject'] = 'Your  Appointment';
        $senddata['body'] = $body;
        $senddata['attachedFile'] = public_path($qrCodePath);
        $senddata['meetingDetails'] = [
            'id' => $appointment->id,  
            'title' => 'Team Meeting',
            'recipient_name' => $request->name,
            'recipient_email' => 'hkushwaha066@gmail.com',
            'date' => '2024-06-25',
            'time' => '10:00 AM',
            'location' => 'India, Vaishali',
            'agenda' => 'Discuss project milestones and deadlines',
            'sender_name' => Auth::user()->name,
        ];
        $sendmailres = $this->sendmail($senddata);
        $appointment->save();

        Session::flash('sa-success', 'appointment Added Successfully !!!');
        return redirect()->route('newappointment');
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
