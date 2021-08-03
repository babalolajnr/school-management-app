<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PerformanceReportExceptionMail extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * Body of the email
     *
     * @var string
     */
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.performanceReportExceptionMail')
            ->subject('Performance Report Mailing Exception')->with('content', $this->content);
    }
}
