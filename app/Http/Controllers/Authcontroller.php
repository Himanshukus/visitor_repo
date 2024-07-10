<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;
use DB;
use Hash;
use Session;
use App\Jobs\SendMailjob;

class Authcontroller extends Controller
{
    public function login()
    {

        return view('auth.login');
    }
    public function loginPost(Request $request)
    {
        // print_r(Hash::make($request->password)); exit;
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            User::where('id', '=', $user->id)->update(
                ['is_online' => true]
            );

            if ($user->portal_user == 1) {
                return redirect()->route('dashboard')->with('success', 'Welcome to Dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account does not have access to the portal');
            }
        }

        return redirect()->route('login')->with('error', 'Login details are not valid');
    }

    public function recoverpw(Request $request)
    {
        return view('auth.recoverpw');
    }
    public function pwreset(Request $request)
    {

        $request->validate([
            'email' => 'required',
        ]);


        $user = User::where('email', $request->email)->first();

        $password = random_int(1000, 9999);

        $logo_path = public_path('assets/images/logo/Seser_logo_horizontal_purple.png');
        $logo_base64 = $this->base64_encode_image($logo_path);


        $body = '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Temporary Password</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                            background-color: #f4f4f4;
                        }
                        .container {
                            width: 100%;
                            max-width: 600px;
                            margin: 0 auto;
                            background-color: #ffffff;
                            padding: 20px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        }
                        .header {
                            background-color: aliceblue;
                            color: #ffffff;
                            padding: 10px 0;
                            text-align: center;
                        }
                        .header img {
                            width: 200px;
                        }
                        .content {
                            padding: 20px;
                            color: #333333;
                            line-height: 1.6;
                        }
                        .content h2 {
                            color: #4CAF50;
                        }
                        .content p {
                            margin: 10px 0;
                        }
                        .temporary-password {
                            background-color: #f1f1f1;
                            padding: 10px;
                            border-left: 4px solid #4CAF50;
                            margin: 20px 0;
                            font-size: 1.2em;
                        }
                        .footer {
                            text-align: center;
                            padding: 20px;
                            font-size: 0.9em;
                            color: #777777;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="header">
                            <img  src="' . $logo_base64 . '" alt="Company Logo">
                        </div>
                        <div class="content">
                            <h2>Hello ' . $user->name . ' ,</h2>
                            <p>We received a request to reset your password. Here is your temporary password:</p>
                            <div class="temporary-password">
                            ' . $password . '
                            </div>
                            <p>Please use this temporary password to log in and change your password immediately to ensure the security of your account.</p>
                            <p>If you did not request a password reset, please contact our support team immediately.</p>
                            <p>Thank you,<br>SESER</p>
                        </div>
                        <div class="footer">
                            <p>&copy; 2024 SESER. All rights reserved.</p>
                            <p> Company Address | Phone Number | <a href="mailto:support@yourcompany.com">support@yourcompany.com</a></p>
                        </div>
                    </div>
                </body>
                </html>
                ';


        $email = $request->email;
        $senddata['name'] = $user->name;
        $senddata['email'] = $email;
        $senddata['subject'] = 'Reset Password';
        $senddata['body'] = $body;
        $sendmailres = $this->sendmail($senddata);
        if ($sendmailres) {
            $user->password = Hash::make($password);
            $user->plainpassword = $password;
            $user->save();
            return redirect()->back()->with('success', 'Please Check Your mail I just Send You a Password');
        } else {
            echo 'something went wrong';
        }
    }
    function base64_encode_image($image_path)
    {
        $image_type = pathinfo($image_path, PATHINFO_EXTENSION);
        $image_data = file_get_contents($image_path);
        $base64_image = 'data:image/' . $image_type . ';base64,' . base64_encode($image_data);
        return $base64_image;
    }

    public function sendmail($request)
    {
        $data['mail'] = $request['email'];
        $data['subject'] = $request['subject'];
        $data['body'] = $request['body'];
        $data['attachedFile'] = null;
        $data['meetingDetails'] = null;

        dispatch(new SendMailJob($data));
        return true;
    }
}
