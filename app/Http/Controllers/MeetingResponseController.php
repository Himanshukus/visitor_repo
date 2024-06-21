<?php

namespace App\Http\Controllers;

use App\Models\Meetingreponse;
use Illuminate\Http\Request;

class MeetingResponseController extends Controller
{
    public function respond( Request $request, $meetingId, $response)
    {
        $email = $request->input('email');

        if (!in_array($response, ['yes', 'no'])) {
            return redirect('/')->with('error', 'Invalid response.');
        }

        Meetingreponse::updateOrCreate(
            ['email' => $email, 'meeting_id' => $meetingId],
            ['response' => $response]
        );

        // return redirect('/')->with('success', 'Your response has been recorded.');
    }
}
