<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
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

        $appointment = Visitor::where('visit_code', $request->visit_code)->first();
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

    public function genrate_badge(Request $request){

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
}
