<?php

namespace App\Jobs;

use App\Mail\StudentPerformanceReport;
use App\Models\Classroom;
use App\Models\Period;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendClassroomPerformanceReportEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * classroom instance
     *
     * @var App\Models\Classroom
     */
    protected $classroom;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Classroom $classroom)
    {
        $this->classroom = $classroom;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $students = $this->classroom->students()->where('is_active', true)->get();
        foreach ($students as $student) {

            if ($student->guardian->email == null) {
                continue;
            }

            Mail::to($student->guardian->email)->send(new StudentPerformanceReport($student, Period::activePeriod()->slug));
        }
    }
}
