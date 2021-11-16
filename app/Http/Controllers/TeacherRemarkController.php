<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\TeacherRemark;
use App\Models\Student;
use Illuminate\Http\Request;

class TeacherRemarkController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Student $student
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function create(Student $student)
    {
        $period = Period::activePeriod();

        if (!Period::activePeriodIsSet()) {
            return back()->with('error', 'Active Period is not set');
        }

        $remark = $student->teacherRemarks()->where('period_id', $period->id);

        if ($remark->exists()) {
            $remark = $remark->first();
        } else {
            $remark = null;
        }

        return view('teacher.create-remark', compact('period', 'student', 'remark'));
    }

    /**
     * Store or Update teacher's remark
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeOrUpdate(Student $student, Request $request)
    {
        $validated = $request->validate([
            'remark' => ['string', 'required']
        ]);

        if (!Period::activePeriodIsSet()) return back()->with('error', 'Active Period is not set');

        TeacherRemark::updateOrCreate(
            [
                'student_id' => $student->id,
                'period_id' => Period::activePeriod()->id,
            ],
            [
                'teacher_id' => $request->user()->id,
                'remark' => $validated['remark'],
            ]
        );

        return back()->with('success', 'Teacher\'s Remark recorded!');
    }
}
