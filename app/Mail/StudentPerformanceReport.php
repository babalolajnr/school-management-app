<?php

namespace App\Mail;

use App\Models\Period;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class StudentPerformanceReport extends Mailable
{
    use Queueable, SerializesModels;

    private $student;

    private $periodSlug;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student, $periodSlug)
    {
        $this->student = $student;
        $this->periodSlug = $periodSlug;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = URL::temporarySignedRoute('result.guardian.show.performance', now()->addDays(7), ['student' => $this->student, 'periodSlug' => $this->periodSlug]);
        $period = Period::where('slug', $this->periodSlug)->first();
        $term = $period->term;
        $academicSession = $period->academicSession;
        $content = [
            'url' => $url,
            'student' => $this->student,
            'guardian' => $this->student->guardian,
            'term' => $term,
            'academicSession' => $academicSession,
        ];

        return $this->markdown('emails.performance-report')
            ->subject('Performance Report')->with('content', $content);
    }
}
