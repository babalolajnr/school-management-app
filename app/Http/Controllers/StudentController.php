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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    /**
     * Show students page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $students = Student::with('guardian')->whereNull('graduated_at')->get();

        // Filter out inactive students
        $students = $students->filter(function ($student) {
            return $student->isActive();
        });

        $academicSessions = AcademicSession::all()->sortByDesc('created_at');
        $terms = Term::all()->sortByDesc('created_at');

        return view('student.index', compact('students', 'academicSessions', 'terms'));
    }

    /**
     * Get Alumni
     *
     * @return \Illuminate\View\View
     */
    public function getAlumni()
    {
        $students = Student::whereNotNull('graduated_at')->get();
        return view('alumni.index', compact('students'));
    }

    /**
     * Get Inactive Students
     *
     * @return \Illuminate\View\View
     */
    public function getInactiveStudents()
    {
        $students = Student::getInactiveStudents();
        return view('student.inactive', compact('students'));
    }

    /**
     * Show create student view
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $classrooms = Classroom::pluck('name')->all();
        return view('student.create', compact('classrooms'));
    }


    /**
     * Store student
     *
     * @param  StoreStudentRequest $request
     * @param  StudentService $studentService
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreStudentRequest $request, StudentService $studentService)
    {
        $studentService->store($request);
        return redirect()->route('student.index')->with('success', 'Student Added!');
    }

    /**
     * Show student
     *
     * @param  Student $student
     * @param  StudentService $studentService
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Student $student, StudentService $studentService)
    {
        return view('student.show', $studentService->show($student));
    }


    /**
     * Activate Student
     *
     * @param  Student $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(Student $student)
    {
        $student->is_active = true;
        $student->save();

        return back()->with('success', 'Student Activated!');
    }

    /**
     * Deactivate student
     *
     * @param  Student $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivate(Student $student)
    {

        $student->is_active = false;
        $student->save();

        return back()->with('success', 'Student Deactivated!');
    }

    /**
     * Edit student
     *
     * @param  Student $student
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Student $student)
    {
        $classrooms = Classroom::pluck('name')->all();
        return view('student.edit', compact(['student', 'classrooms']));
    }

    /**
     * Update student's record
     *
     * @param  Student $student
     * @param  UpdateStudentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Student $student, UpdateStudentRequest $request)
    {
        $classroom_id = Classroom::where('name', $request->validated()['classroom'])->first()->id;
        $student->update($request->validated() + ['classroom_id' => $classroom_id]);
        return redirect(route('student.edit', ['student' => $student]))->with('success', 'Student Updated!');
    }

    /**
     * Get student's sessional results
     *
     * @param  Student $student
     * @param  mixed $academicSessionName
     * @param  StudentService $studentService
     * @return \Illuminate\Contracts\View\View
     */
    public function getSessionalResults(Student $student, $academicSessionName, StudentService $studentService)
    {
        $sessionalResults = $studentService->getSessionalResults($student, $academicSessionName);
        return view('student.sessional-results', $sessionalResults);
    }

    /**
     * Get student's term results
     *
     * @param  Student $student
     * @param  mixed $termSlug
     * @param  mixed $academicSessionName
     * @param  StudentService $studentService
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function getTermResults(Student $student, $termSlug, $academicSessionName, StudentService $studentService)
    {
        try {
            $termResults = $studentService->getTermResults($student, $termSlug, $academicSessionName);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('student.term-results', $termResults);
    }

    /**
     * Soft delete student record
     *
     * @param  Student $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Student $student)
    {
        $this->authorize('delete', $student);

        $student->delete();

        return back()->with('success', 'Student deleted');
    }

    /**
     * Delete student's record permanently
     *
     * @param  mixed $id
     * @param  Student $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id, Student $student)
    {
        $this->authorize('delete', $student);

        $student = Student::withTrashed()->findOrFail($id);
        $guardian = $student->guardian;
        $guardianChildren = $guardian->children()->withTrashed()->get();

        //delete student image if it exists
        if (!is_null($student->image)) {
            $deletePath = $student->image;
            $deletePath = str_replace('storage/', '', $deletePath);
            $deletePath = 'public/' . $deletePath;

            Storage::delete($deletePath);
        }

        /**if guardian has more than one child delete only the student's 
         * data else delete the student and the guargian's data
         */
        if (count($guardianChildren) > 1) {
            $student->forceDelete();
        } else {
            $student->forceDelete();
            $guardian->delete();
        }

        return back()->with('success', 'Student deleted permanently');
    }

    /**
     * Upload student's image
     *
     * @param  Student $student
     * @param  Request $request
     * @param  StudentService $studentService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadImage(Student $student, Request $request, StudentService $studentService)
    {
        $studentService->uploadImage($student, $request);
        return back()->with('success', 'Image uploaded successfully');
    }

    /**
     * Show Student's settings view
     *
     * @param  Student $student
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showStudentSettingsView(Student $student)
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
     *
     * @param  Student $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function promote(Student $student)
    {

        $classRank = $student->classroom->rank;
        $highestClassRank = Classroom::max('rank');

        if ($classRank !== $highestClassRank) {
            $newClassRank = $classRank + 1;
            $newClassId = Classroom::where('rank', $newClassRank)->first()->id;
            $student->classroom_id = $newClassId;
            $student->save();

            return back()->with('success', 'Student Promoted!');
        }

        return back()->with('error', 'Student is in the Maximum class possible');
    }

    /**
     * Demote student
     *
     * @param  Student $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function demote(Student $student)
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
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showTrashed()
    {
        $students = Student::onlyTrashed()->get();

        return view('student.trash', compact('students'));
    }

    /**
     * Restore deleted student
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $student->restore();

        return back()->with('success', 'Student restored!');
    }

    /**
     * Store student gradation date
     *
     * @param  Student $student
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function graduate(Student $student, Request $request)
    {
        if (!Period::activePeriodIsSet()) {
            return back()->with('error', 'Active Period is not set');
        }

        $activePeriod = Period::activePeriod();

        $validated = $request->validate([
            'graduated_at' => ['required', 'date', "before_or_equal:{$activePeriod->academicSession->end_date}"]
        ]);

        $student->graduated_at = $validated['graduated_at'];
        $student->is_active = false;
        $student->save();

        return back()->with('success', 'Student Graduated!');
    }

    /**
     * Set Classroom branch in which student belongs
     *
     * @param  Student $student
     * @param  Branch $branch
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setClassroomBranch(Student $student, Branch $branch)
    {
        $classroom = $student->classroom;
        $classroomBranch = BranchClassroom::where('classroom_id', $classroom->id)->where('branch_id', $branch->id)->first();

        $student->update(['branch_classroom_id' => $classroomBranch->id]);

        return back()->with('success', "Student Moved to $branch->name");
    }
}
