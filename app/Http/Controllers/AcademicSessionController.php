<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use App\Traits\ValidationTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AcademicSessionController extends Controller
{
    use ValidationTrait;

    private function validateAcademicSession($request, $academicSession = null)
    {
        $messages = [
            'name.required' => 'This field is required',
            'name.unique' => 'Record exists',
            'name.regex' => 'Academic session format is invalid'
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', Rule::unique('academic_sessions')->ignore($academicSession), 'regex:/^\d{4}[-]{1}\d{4}$/m'],
            'start_date' => ['required', 'date', Rule::unique('academic_sessions')->ignore($academicSession)],
            'end_date' => ['required', 'date', Rule::unique('academic_sessions')->ignore($academicSession), 'after:start_date']
        ], $messages);

        return $validatedData;
    }

    public function edit(AcademicSession $academicSession)
    {
        return view('academic-session.edit', compact('academicSession'));
    }

    public function update(AcademicSession $academicSession, Request $request)
    {
        $data = $this->validateAcademicSession($request, $academicSession);

        //check if date range is unique
        $validateDateRange = $this->validateDateRange($data['start_date'], $data['end_date'], AcademicSession::class, $academicSession);

        if ($validateDateRange !== true) {
            return back()->with('error', 'Date range overlaps with another Academic session');
        }

        $academicSession->update($data);

        return redirect()->route('academic-session.index')->with('success', 'Academic Session Updated!');
    }
}
