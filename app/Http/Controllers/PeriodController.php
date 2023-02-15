<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use App\Models\AcademicSession;
use App\Models\Period;
use App\Models\Term;
use App\Services\PeriodService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PeriodController extends Controller
{
    public function index(): View|Factory
    {
        $periods = Period::with(['term', 'academicSession'])->get();
        $academicSessions = AcademicSession::all();
        $terms = Term::all();

        return view('period.index', compact('periods', 'academicSessions', 'terms'));
    }

    public function store(StorePeriodRequest $request): RedirectResponse
    {
        $periodService = new PeriodService();

        $periodService->store($request);

        return back()->with('success', 'Record Created!');
    }

    public function edit(Period $period): View|Factory
    {
        return view('period.edit', compact('period'));
    }

 
    public function update(UpdatePeriodRequest $request, Period $period): RedirectResponse
    {
        $period->update($request->validated());

        return back()->with('success', 'Period updated successfully');
    }

    public function setActivePeriod(Period $period): RedirectResponse
    {
        $activePeriod = Period::where('active', true)->first();

        if ($activePeriod != null) {
            $activePeriod->update(['active' => null]);
        }

        $period->update(['active' => true]);

        return back()->with('success', "{$period->academicSession->name} {$period->term->name} is now active");
    }

    
    public function destroy(Period $period): RedirectResponse
    {
        try {
            $period->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return back()->with('error', 'Period cannot be deleted because some resources are dependent on it!');
            }
        }

        return back()->with('success', 'Deleted!');
    }

    /**
     * When results of a period is published guardians can view the result of their wards from their portals
     */
    public function togglePublishResults(Period $period): RedirectResponse
    {
        if (!$period->results_published_at) {
            $period->update(['results_published_at' => now()]);
            return back()->with('success', 'Results published!');
        }
        
        $period->update(['results_published_at' => null]);
        return back()->with('success', 'Results unpublished!');
    }
}
