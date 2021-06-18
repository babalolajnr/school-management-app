<?php

namespace App\Http\Controllers;

use App\Models\HosRemark;
use App\Models\Period;
use App\Models\Student;
use Illuminate\Http\Request;

class HosRemarkController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param Student $student
     * @return \Illuminate\Http\Response
     */
    public function create(Student $student)
    {
        if (!Period::activePeriodIsSet()) return back()->with('error', 'Active Period is not set');

        $period = Period::activePeriod();

        $remark = $student->hosRemarks()->where('period_id', $period->id);

        if ($remark->exists()) {
            $remark = $remark->first();
        } else {
            $remark = null;
        }

        return view('createHosRemark', compact('period', 'student', 'remark'));
    }

    /**
     * Store or update Hos remark
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdate(Student $student, Request $request)
    {
        if (!Period::activePeriodIsSet()) return back()->with('error', 'Active Period is not set');

        $validated = $request->validate([
            'remark' => ['string', 'required']
        ]);


        $activePeriod = Period::activePeriod();
        HosRemark::updateOrCreate(
            [
                'student_id' => $student->id,
                'period_id' => $activePeriod->id,
            ],
            [
                'user_id' => $request->user()->id,
                'remark' => $validated['remark'],
            ]
        );

        return redirect(route('result.show.performance', ['student' => $student, 'periodSlug' => $activePeriod->slug]))->with('success', 'HOS Remark recorded!');
    }
}
