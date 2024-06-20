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
        $department = new Department();
        $department->name = $request->name;

        $department->save();
        Session::flash('sa-success', 'Department Added Successfully !!!');
        return redirect()->route('department');
    }
}
