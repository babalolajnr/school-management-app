<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Period;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Student $student)
    {
        if (Period::activePeriodIsNotSet()) {
            return redirect()->back()->with('error', 'Active period is not set!');
        }

        $period = Period::activePeriod();

        $attendance = $student->attendances()->where('period_id', $period->id);

        if ($attendance->exists()) {
            $attendance = $attendance->first();

            return view('attendance.create', compact('attendance', 'period', 'student'));
        }

        return view('attendance.create', compact('period', 'student'));
    }

    /**
     * Store or update attendance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeOrUpdate(Request $request, Student $student, $periodSlug = null)
    {
        if (! is_null($periodSlug)) {
            $period = Period::where('slug', $periodSlug)->firstOrFail();
        } else {
            $period = Period::activePeriod();
        }

        if ($period->no_times_school_opened == null) {
            return back()->with('error', 'No of days school opened is null. Contact the admin!');
        }

        $data = $request->validate([
            'value' => ['required', 'numeric', "max:{$period->no_times_school_opened}"],
        ]);

        $student->attendances()->updateOrCreate([
            'period_id' => $period->id,
        ], ['value' => $data['value']]);

        return redirect(route('result.show.performance', ['student' => $student, 'periodSlug' =>  Period::activePeriod()->slug]));
    }
}
