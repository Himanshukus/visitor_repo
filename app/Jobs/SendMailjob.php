<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class SendMailjob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public  $mail;
    public $subject;
    public $body;
    public $attachedFile;
    public function __construct($data)
    {
        $this->mail = $data['mail'];
        $this->subject = $data['subject'];
        $this->body = $data['body'];
        $this->attachedFile = $data['attachedFile'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->mail)->send(new SendMail($this->subject, $this->body, $this->attachedFile));
    }
}
