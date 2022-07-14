<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use App\Traits\ValidationTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AcademicSessionController extends Controller
{
    use ValidationTrait;

    /**
     * validate Academic Session
     *
     * @param  mixed  $request
     * @param  mixed  $academicSession
     * @return array
     */
    private function validateAcademicSession($request, $academicSession = null): array
    {
        $messages = [
            'name.required' => 'This field is required',
            'name.unique' => 'Record exists',
            'name.regex' => 'Academic session format is invalid',
		];

        return $request->validate([
            'name' => [
                'required', 'string',
                Rule::unique('academic_sessions')->ignore($academicSession),
                'regex:/^\d{4}[-]{1}\d{4}$/m',
            ],
            'start_date' => [
                'required',
                'date',
                Rule::unique('academic_sessions')->ignore($academicSession),
            ],
            'end_date' => [
                'required',
                'date',
                Rule::unique('academic_sessions')->ignore($academicSession), 'after:start_date',
            ],
        ], $messages);
    }

    /**
     * Display a edit view of the resource.
     *
     * @param  AcademicSession  $academicSession
     * @return Illuminate\Contracts\View\View
     */
    public function edit(AcademicSession $academicSession): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        // // Log activity
        // \activity()->causedBy(auth()->user())
        //     ->on($academicSession)
        //     ->log("Requested Academic Session edit form");

        return view('academic-session.edit', compact('academicSession'));
    }

    /**
     * update Academic Session
     *
     * @param  AcademicSession  $academicSession
     * @param  Request  $request
     * @return Illuminate\Routing\Redirector
     */
    public function update(AcademicSession $academicSession, Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $data = $this->validateAcademicSession($request, $academicSession);

        //check if date range is unique
        $dateOverlaps = $this->dateOverlaps(
            $data['start_date'],
            $data['end_date'],
            AcademicSession::class,
            $academicSession
        );

        if ($dateOverlaps) {
            return back()->with('error', 'Date range overlaps with another Academic session');
        }

        $academicSession->update($data);

        // // Log activity
        // \activity()->causedBy(auth()->user())
        //     ->on($academicSession)
        //     ->log("Updated Academic Session");

        return redirect()->route('academic-session.index')->with('success', 'Academic Session Updated!');
    }
}
