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
     * @param  mixed $request
     * @param  mixed $academicSession
     * @return array
     */
    private function validateAcademicSession($request, $academicSession = null): array
    {
        $messages = [
            'name.required' => 'This field is required',
            'name.unique' => 'Record exists',
            'name.regex' => 'Academic session format is invalid'
        ];

        $validatedData = $request->validate([
            'name' => [
                'required', 'string',
                Rule::unique('academic_sessions')->ignore($academicSession),
                'regex:/^\d{4}[-]{1}\d{4}$/m'
            ],
            'start_date' => [
                'required',
                'date',
                Rule::unique('academic_sessions')->ignore($academicSession)
            ],
            'end_date' => [
                'required',
                'date',
                Rule::unique('academic_sessions')->ignore($academicSession), 'after:start_date'
            ]
        ], $messages);

        return $validatedData;
    }

    public function edit(AcademicSession $academicSession)
    {
        // // Log activity
        // \activity()->causedBy(auth()->user())
        //     ->on($academicSession)
        //     ->log("Requested Academic Session edit form");

        return view('academic-session.edit', compact('academicSession'));
    }

    public function update(AcademicSession $academicSession, Request $request)
    {
        $data = $this->validateAcademicSession($request, $academicSession);

        //check if date range is unique
        $validateDateRange = $this->validateDateRange(
            $data['start_date'],
            $data['end_date'],
            AcademicSession::class,
            $academicSession
        );

        if ($validateDateRange !== true) {
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
