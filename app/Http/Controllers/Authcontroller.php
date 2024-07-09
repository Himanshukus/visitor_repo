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

        $body = '<head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
                <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
                <style type="text/css">
                    @media only screen and (max-width: 550px){
                        .responsive_at_550{
                            width: 90% !important;
                            max-width: 90% !important;
                        }
                    }
                </style>
            </head>
            <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">        
                    <tbody>
            <tr>
                <td align="center" bgcolor="#808080">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                        <tbody>
                            <tr>
                                <td width="100%" align="center">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td height="40">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="200" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td width="100%" align="center">
                                                    <img width="200" height="100" src="' . $logo_base64 . '" alt="Logo" border="0" style="text-align: center; background:white"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td height="40">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" style="padding-left:20px; padding-right:20px;" class="responsive_at_550">
                                        <tbody>
                                            <tr>
                                                <td align="center" bgcolor="#ffffff">
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td width="100%" height="7" align="center" border="0" bgcolor="#03a9f4"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td height="30">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td width="100%" align="center">
                                                                <h1 style="font-family:\'Ubuntu Mono\', monospace; font-size:20px; color:#202020; font-weight:bold; padding-left:20px; padding-right:20px;">Password Reset</h1>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                           <tr>
                                                            <td width="100%" align="center">
                                                                <p style="font-family:\'Ubuntu\', sans-serif; font-size:14px; color:#202020; padding-left:20px; padding-right:20px; text-align:justify;">Dear ' . $user->name . ',</p>
                                                                <p style="font-family:\'Ubuntu\', sans-serif; font-size:14px; color:#202020; padding-left:20px; padding-right:20px; text-align:justify;">Please use the following password to log in:</p>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td height="30">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                 
                                                    <table width="200" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" bgcolor="#1976D2">
                                                                                <h2 style="font-family:\'Ubuntu Mono\', monospace; display:block; color:#ffffff; font-size:14px; font-weight:bold; text-decoration:none; padding-left:20px; padding-right:20px; padding-top:20px; padding-bottom:20px;" >' . $password . '</h2>
                                                                            </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                             <tr>
                                                                            <td width="100%" align="center">
                                                                                <p style="font-family:\'Ubuntu\', sans-serif; font-size:14px; color:#202020; padding-left:20px; padding-right:20px; text-align:justify;">For security reasons, we recommend changing your password after logging in.</p>
                                                                            </td>
                                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                   
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td height="30">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                 
                                                  
                                              
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td height="30">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                             
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td height="40">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                            <td width="100%" align="center" style="padding-left:15px; padding-right:15px;">
                                                <p style="font-family:\'Ubuntu Mono\', monospace; color:#ffffff; font-size:12px;">Beaconcoders &copy; 2024, All Rights Reserved</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" align="center" style="padding-left:15px; padding-right:15px;">
                                                <a href="" style="text-decoration:underline; font-family:\'Ubuntu Mono\', monospace; color:#ffffff; font-size:12px;">Terms of Use</a>
                                                <span style="font-family:\'Ubuntu Mono\', monospace; color:#ffffff;">|</span>
                                                <a href="" style="text-decoration:underline; font-family:\'Ubuntu Mono\', monospace; color:#ffffff; font-size:12px;">Privacy Policy</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td height="40">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>        
    </table>
</body>';


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
