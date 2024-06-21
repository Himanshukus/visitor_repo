<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Carbon\Carbon;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $body;
    public $attachedFile;
    public $meetingDetails;

    public function __construct($subject, $body, $attachedFile = null, $meetingDetails = null)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->attachedFile = $attachedFile;
        $this->meetingDetails = $meetingDetails;
    }
    /**
     * Build the message.
     */
    public function build()
    {
        // return $this->subject($this->subject)
        //     ->view('sendmail')
        //     ->with(['body' => $this->body]);
        $email = $this->subject($this->subject)
            ->view('sendmail')
            ->with(['body' => $this->body]);

        // Attach file if provided
        if ($this->attachedFile) {
            $email->attach($this->attachedFile);
        }

        // Generate and attach ICS file if meeting details are provided
        if ($this->meetingDetails) {
            $icsContent = $this->generateIcs();
            $email->attachData($icsContent, 'meeting.ics', [
                'mime' => 'text/calendar',
            ]);
        }

        return $email;
    }
    protected function generateIcs()
    {
        $dtStart = Carbon::parse($this->meetingDetails['date'] . ' ' . $this->meetingDetails['time']);
        $dtEnd = $dtStart->copy()->addHour(); // Assuming a 1-hour meeting

        $icsContent = "BEGIN:VCALENDAR\n";
        $icsContent .= "VERSION:2.0\n";
        $icsContent .= "PRODID:-//Your Company//Your Product//EN\n";
        $icsContent .= "BEGIN:VEVENT\n";
        $icsContent .= "UID:" . uniqid() . "@yourdomain.com\n";
        $icsContent .= "DTSTAMP:" . $dtStart->format('Ymd\THis\Z') . "\n";
        $icsContent .= "DTSTART:" . $dtStart->format('Ymd\THis\Z') . "\n";
        $icsContent .= "DTEND:" . $dtEnd->format('Ymd\THis\Z') . "\n";
        $icsContent .= "SUMMARY:" . $this->meetingDetails['title'] . "\n";
        $icsContent .= "DESCRIPTION:" . $this->meetingDetails['agenda'] . "\n";
        $icsContent .= "LOCATION:" . $this->meetingDetails['location'] . "\n";
        $icsContent .= "END:VEVENT\n";
        $icsContent .= "END:VCALENDAR\n";

        return $icsContent;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->attachedFile) {
            $attachments[] = Attachment::fromPath($this->attachedFile);
        }

        return $attachments;
    }
}
