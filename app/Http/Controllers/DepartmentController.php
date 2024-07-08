<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class DepartmentController extends Controller
{
    public function index()
    {
        $data = Department::all();

        return view('department.index', compact('data'));
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
            $department = Department::where('id', $request->id)->first();
        } else {
            $department = new Department();
        }
        $department->name = $request->name;

        $department->save();
        Session::flash('sa-success', 'Department Added Successfully !!!');
        return redirect()->route('department');
    }

    public function getdepartmentByid(Request $request)
    {

        $apt = Department::find($request->id);
        if ($apt) {
            return response()->json(['error' => false, 'data' => $apt]);
        } else {
            return response()->json('data not found');
        }
    }
    public function deletedepartment(Request $request)
    {
        
        $department = Department::find($request->id);
        if (!$department) {
            Session::flash('sa-error', 'Department Not Found !!!');
            return redirect()->route('department');
        } else {
            $department->delete();
            Session::flash('sa-success', 'Department Added Successfully !!!');
            return redirect()->route('department');
        }
    }
}
