<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Models\User;
use Hash;
class StaffController extends Controller
{
    public function index()
    {
        $data = User::with('department')->get();
        
        $department = Department::all();
        return view('staff.index', compact('data', 'department'));
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'department_id' => 'required',
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
            $staff = User::where('id', $request->id)->first();
        } else {
            $staff = new User();
        }
        $staff->name = $request->name;
        $staff->email = $request->email;

        if ($request->has('profile_picture')) {
            $folderPath = 'uploads/profilepicture/';
            $image = $request->profile_picture;
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($folderPath), $fileName);
            $filePath = '/public/uploads/profilepicture/' . $fileName;
            $staff->profile_picture = $filePath;
        }

        $password = random_int(1000, 9999);
        $staff->password = Hash::make($password);
        $staff->department_id = $request->department_id;
        $staff->save();

        Session::flash('sa-success', 'Staff Member Added Successfully !!!');
        return redirect()->route('staff');
    }

    public function getstaffByid(Request $request)
    {

        $apt = User::find($request->id);
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
        $staff = User::find($request->id);
        if (!$staff) {
            $errordata = [
                'error' => true,
                'errors' => $validator->errors(),
                'msg' => 'ID Not Found',
            ];
            return response()->json($errordata, 200);
        } else {
            $staff->delete();
            return response()->json("Appointment Deleted Successfully !");
        }
    }

    public function profile(Request $request){
     

        if ($request->has('file')) {
            $folderPath = 'uploads/profilepicture/';
            $image = $request->file;
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($folderPath), $fileName);
            $filePath = '/public/uploads/profilepicture/' . $fileName;
        }
    }
}