<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\AcademicSession;
use App\Models\Branch;
use App\Models\BranchClassroom;
use App\Models\Classroom;
use App\Models\PDType;
use App\Models\Period;
use App\Models\Student;
use App\Models\Term;
use App\Services\StudentService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Show students page
     */
    public function index(): View
    {
        $students = Student::with(['guardian', 'classroom.branches'])->whereNull('graduated_at')->whereIsActive(true)->get();

        $academicSessions = AcademicSession::all()->sortByDesc('created_at');
        $terms = Term::all()->sortByDesc('created_at');

        return view('student.index', compact('students', 'academicSessions', 'terms'));
    }

    public function getAlumni(): View
    {
        $students = Student::whereNotNull('graduated_at')->get();

        return view('alumni.index', compact('students'));
    }

    public function getInactiveStudents(): View
    {
        $students = Student::inactiveStudents();

        return view('student.inactive', compact('students'));
    }

    public function create(): View
    {
        $classrooms = Classroom::pluck('name')->all();

        return view('student.create', compact('classrooms'));
    }

    public function store(StoreStudentRequest $request): Redirector|RedirectResponse
    {
        StudentService::store($request);

        return redirect()->route('student.index')->with('success', 'Student Added!');
    }

    public function show(Student $student): View|Factory
    {
        return view('student.show', StudentService::show($student));
    }

    /**
     * Activate Student
     */
    public function activate(Student $student): RedirectResponse
    {
        $student->is_active = true;
        $student->save();

        return back()->with('success', 'Student Activated!');
    }

    /**
     * Deactivate student
     */
    public function deactivate(Student $student): RedirectResponse
    {
        $student->is_active = false;
        $student->save();

        return back()->with('success', 'Student Deactivated!');
    }

    /**
     * Edit student
     */
    public function edit(Student $student): View
    {
        $classrooms = Classroom::pluck('name')->all();

        return view('student.edit', compact(['student', 'classrooms']));
    }

    /**
     * Update student's record
     *
     */
    public function update(Student $student, UpdateStudentRequest $request): RedirectResponse
    {
        $classroom_id = Classroom::where('name', $request->validated()['classroom'])->first()->id;
        $student->update($request->validated() + ['classroom_id' => $classroom_id]);

        return redirect(route('student.edit', ['student' => $student]))->with('success', 'Student Updated!');
    }

    /**
     * Get student's sessional results
     */
    public function getSessionalResults(Student $student, string $academicSessionName): View
    {
        $sessionalResults = StudentService::getSessionalResults($student, $academicSessionName);

        return view('student.sessional-results', $sessionalResults);
    }

    /**
     * Get student's term results
     */
    public function getTermResults(Student $student, string $termSlug, string $academicSessionName): View|RedirectResponse
    {
        try {
            $termResults = StudentService::getTermResults($student, $termSlug, $academicSessionName);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('student.term-results', $termResults);
    }

    /**
     * Soft delete student record
     */
    public function destroy(Student $student): RedirectResponse
    {
        $this->authorize('delete', $student);

        $student->delete();

        return back()->with('success', 'Student deleted');
    }

    /**
     * Delete student's record permanently
     */
    public function forceDelete(string $id, Student $student): RedirectResponse
    {
        $this->authorize('delete', $student);

        $student = Student::withTrashed()->findOrFail($id);
        $guardian = $student->guardian;
        $guardianChildren = $guardian->children()->withTrashed()->get();

        try {

            /**
             * if guardian has more than one child delete only the student's
             * data else delete the student and the guardian's data
             */
            if (count($guardianChildren) > 1) {
                $student->forceDelete();
            } else {
                $student->forceDelete();
                $guardian->delete();
            }

            //delete student image if it exists
            if ($student->image) {
                $deletePath = $student->image;
                $deletePath = str_replace('storage/', '', $deletePath);
                $deletePath = 'public/' . $deletePath;

                Storage::delete($deletePath);
            }
        } catch (\Throwable $th) {
            return back()->with('error', "An error occurred during the request. Please try again, Error code: {$th->getCode()}");
        }

        return back()->with('success', 'Student deleted permanently');
    }

    /**
     * Upload student's image
     */
    public function uploadImage(Student $student, Request $request):RedirectResponse
    {
        StudentService::uploadImage($student, $request);

        return back()->with('success', 'Image uploaded successfully');
    }

    /**
     * Show Student's settings view
     */
    public function showStudentSettingsView(Student $student): RedirectResponse|View
    {
        $currentAcademicSession = Period::activePeriod()->academicSession;

        if (is_null($currentAcademicSession)) {
            return back()->with('error', 'Current Academic Session is not set');
        }

        $pdTypes = PDType::all();
        $terms = Term::all();

        return view('student.settings', compact('student', 'pdTypes', 'currentAcademicSession', 'terms'));
    }

    /**
     * Promote Student
     */
    public function promote(Student $student): RedirectResponse
    {
        $classRank = $student->classroom->rank;
        $highestClassRank = Classroom::max('rank');

        if ($classRank !== $highestClassRank) {
            $newClassRank = $classRank + 1;
            $newClassId = Classroom::where('rank', $newClassRank)->first()->id;
            $student->classroom_id = $newClassId;

            // Set branch classroom to null
            $student->branch_classroom_id = null;

            $student->save();

            return back()->with('success', 'Student Promoted!');
        }

        return back()->with('error', 'Student is in the Maximum class possible');
    }

    /**
     * Demote student
     */
    public function demote(Student $student): RedirectResponse
    {
        $classRank = $student->classroom->rank;
        $lowestClassRank = Classroom::min('rank');

        //if the student is not in the lowest class then demote the student
        if ($classRank !== $lowestClassRank) {
            $newClassRank = $classRank - 1;
            $newClassId = Classroom::where('rank', $newClassRank)->first()->id;
            $student->classroom_id = $newClassId;

            // if student has graduated, 'ungraduate' the student
            if (!is_null($student->graduated_at)) {
                $student->graduated_at = null;
            }

            $student->save();

            return back()->with('success', 'Student Demoted!');
        }

        return back()->with('error', 'Student is in the Lowest class possible');
    }

    /**
     * Show trashed students
     */
    public function showTrashed(): View
    {
        $students = Student::onlyTrashed()->get();

        return view('student.trash', compact('students'));
    }

    /**
     * Restore deleted student
     *
     */
    public function restore(string $id): RedirectResponse
    {
        $student = Student::withTrashed()->findOrFail($id);
        $student->restore();

        return back()->with('success', 'Student restored!');
    }

    /**
     * Store student gradation date
     */
    public function graduate(Student $student, Request $request): RedirectResponse
    {
        if (Period::activePeriodIsNotSet()) {
            return back()->with('error', 'Active Period is not set');
        }

        $activePeriod = Period::activePeriod();

        $validated = $request->validate([
            'graduated_at' => ['required', 'date', "before_or_equal:{$activePeriod->academicSession->end_date}"],
        ]);

        $student->graduated_at = $validated['graduated_at'];
        $student->is_active = false;
        $student->save();

        return back()->with('success', 'Student Graduated!');
    }

    /**
     * Set Classroom branch in which student belongs
     */
    public function setClassroomBranch(Student $student, Branch $branch): RedirectResponse
    {
        $classroom = $student->classroom;
        $classroomBranch = BranchClassroom::where('classroom_id', $classroom->id)->where('branch_id', $branch->id)->first();

        $student->update(['branch_classroom_id' => $classroomBranch->id]);

        return back()->with('success', "Student Moved to $branch->name");
    }
}