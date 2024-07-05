<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        // echo '<pre>';
        // print_r(Auth::user()->name); exit;
        $department = Department::all();

        return view('auth.profile', compact('department'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $id = Auth::user()->id;
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        $image = $request->imgupload;
        if ($image) {
            if (!empty($id)) {
                $path = (array)Auth::user()->profile_picture;
                if (isset($path[0]) && $path[0]) {
                    $image_path = public_path($path[0]);
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
            }

            $name = $image->getClientOriginalName();
            $destinationPath = public_path('/uploads/profilepicture');
            $createname = date('d-m-y') . time() . $name;
            $image->move($destinationPath, $createname);

            $data['profile_picture'] = '/uploads/profilepicture/' . $createname;
        }
        User::where('id', $id)->update($data);
        return back()->with("status", "Profile Updated successfully!");
    }

    public function UpdatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|confirmed',
        ]);

        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user = User::where('id', '=', $user->id)->update(
            ['is_online' => false]
        );
        Auth::logout();
        return Redirect()->route('login')->with('success', 'Logged Out Successfully...');
    }
}
