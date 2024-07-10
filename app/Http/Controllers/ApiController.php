<?php

namespace App\Http\Controllers;

use App\Models\setting;
use App\Models\User;
use App\Models\Visitlog;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Validator;

class ApiController extends Controller
{
    public function visitcode(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'visit_code' => 'required',
        ]);
        if ($validator->fails()) {
            $errordata = [
                'error' => true,
                'errors' => $validator->errors(),
                'msg' => 'Please enter visit code'
            ];
            return response()->json($errordata, 200);
        }

        $appointment = Visitor::where('visit_code', $request->visit_code)->with(['host' => function ($query) {
            $query->select('id', 'name');
        }])->first();
        
        if ($appointment) {

            return response(['error' => false, 'msg' => 'visitor entry code matched', 'data' => $appointment]);
        } else {
            return response()->json(['error' => true, 'msg' => 'No Appointment Found With This Visit Code']);
        }
    }

    public function takephoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'selfie' => 'required',
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $errordata = [
                'error' => true,
                'errors' => $validator->errors(),
                'msg' => 'Please enter visit code'
            ];
            return response()->json($errordata, 200);
        }
        $appointment = Visitor::where('id', $request->id)->first();
        if ($appointment) {
            $folderPath = 'uploads/selfie/';
            $image = $request->selfie;
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($folderPath), $fileName);
            $filePath = '/public/uploads/selfie/' . $fileName;
            $appointment->real_time_photo = $filePath;
            $appointment->save();
            $data = [
                'appointment_id' => $appointment->id,
            ];
            return response()->json(['error' => false, 'msg' => 'Selfie Captured Successfully', 'data' => $data]);
        } else {
            return response()->json(['error' => true, 'msg' => 'No Appointment Found With This Id Code']);
        }
    }

    public function genrate_badge(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errordata = [
                'error' => true,
                'errors' => $validator->errors(),
                'msg' => 'Please enter visit code'
            ];
            return response()->json($errordata, 200);
        }

        $appointment = Visitor::where('id', $request->appointment_id)->first();
        if ($appointment) {

            return response(['error' => false, 'msg' => 'success', 'data' => $appointment]);
        } else {
            return response()->json(['error' => true, 'msg' => 'No Appointment Found With This Appointment Id']);
        }
    }

    public function walkinvisitor(Request $request)
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

        $appointment = new Visitor();

        $appointment->name = $request->name;
        $appointment->email = $request->email;
        $appointment->visit_date = Carbon::now();
        $appointment->time = $request->time;
        $appointment->host_id = $request->host_id;

        if ($request->has('phone')) {
            $appointment->phone = $request->phone;
        }
        $today = Carbon::today()->toDateString();
        $appointment->visit_date = $today;

        if ($request->has('companyname')) {
            $appointment->companyname = $request->companyname;
        }
        $appointment->type = 'single';
        if ($request->has('purpose')) {
            $appointment->purpose = $request->purpose;
        }
        $code = random_int(1000, 9999);
        $appointment->visit_code = $code;

        $appointment->save();

        $visitlogs = new Visitlog();
        $visitlogs->visitor_id = $appointment->id;
        $visitlogs->action = 'check-in';
        $visitlogs->entry_time = $request->time;
        $today = Carbon::today()->toDateString();
        $appointment->date = $today;
        $visitlogs->exit_time = $request->exit_time;
        return response(['error' => false, 'msg' => 'success', 'data' => $appointment]);
    }

    public function groupcheckin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'visit_code' => 'required',
        ]);
        if ($validator->fails()) {
            $errordata = [
                'error' => true,
                'errors' => $validator->errors(),
                'msg' => 'Please enter visit code'
            ];
            return response()->json($errordata, 200);
        }

        $appointment = Visitor::where('visit_code', $request->visit_code)->get();
        if ($appointment) {

            return response(['error' => false, 'msg' => 'visitor entry code matched', 'data' => $appointment]);
        } else {
            return response()->json(['error' => true, 'msg' => 'No Appointment Found With This Visit Code']);
        }
    }
    public function getallstaff(Request $request)
    {
        $data = User::all();
        if ($data) {
            return response(['error' => false, 'msg' => 'success', 'data' => $data]);
        } else {
            return response(['error' => false, 'msg' => 'data not found', 'data' => null]);
        }
    }
    public function settings(Request $request)
    {
        $data = setting::all();
        
        if ($data) {
            return response(['error' => false, 'msg' => 'success', 'data' => $data]);
        } else {
            return response(['error' => false, 'msg' => 'data not found', 'data' => null]);
        }
    }
}
