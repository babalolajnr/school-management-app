<?php

namespace App\Services;

use App\Http\Requests\StoreStudentRequest;
use App\Models\AcademicSession;
use App\Models\Classroom;
use App\Models\Guardian;
use App\Models\Period;
use App\Models\Result;
use App\Models\Student;
use App\Models\Term;
use Exception;
use Illuminate\Validation\ValidationException;
use  Intervention\Image\Facades\Image;

class StudentService
{
    /**
     * store student
     *
     * This method works by collecting all the guardian and student info from the user and
     * making sure it's all filled out. Then it checks if the guardian's phone number is present
     * in the database. If it is then it gets the guardian's id and inserts it into the student's guardian id column
     *
     * @param  StoreStudentRequest  $storeStudentRequest
     * @return void
     */
    public static function store(StoreStudentRequest $storeStudentRequest)
    {
        //merge guardian and student validation rules
        $validatedData = $storeStudentRequest->validated();

        $guardian = Guardian::where('phone', $validatedData['guardian_phone'])->first();

        //if guardian does not exist create new guardian
        if (! $guardian) {
            //Check if the email matches an existing email
            $matchedEmail = Guardian::whereEmail($validatedData['guardian_email'])->first();
            if ($matchedEmail) {
                throw ValidationException::withMessages(['guardian_email' => 'Guardian email already exists']);
            }

            $guardian = Guardian::create([
                'title' => $validatedData['guardian_title'],
                'first_name' => $validatedData['guardian_first_name'],
                'last_name' => $validatedData['guardian_last_name'],
                'email' => $validatedData['guardian_email'],
                'phone' => $validatedData['guardian_phone'],
                'occupation' => $validatedData['guardian_occupation'],
                'address' => $validatedData['guardian_address'],
            ]);
        }

        //merge guardian id with student info
        $studentInfo = array_merge(Self::studentInfo($validatedData), ['guardian_id' => $guardian->id]);

        Student::create($studentInfo);
    }

    /**
     * @param  mixed  $validatedData
     *
     * returns student info after it been extracted from
     * the validated data
     * @return array
     */
    private static function studentInfo($validatedData): array
    {
        $classroom = Classroom::where('name', $validatedData['classroom'])->first();

        return [
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'sex' => $validatedData['sex'],
            'admission_no' => $validatedData['admission_no'],
            'lg' => $validatedData['lg'],
            'state' => $validatedData['state'],
            'country' => 'Nigeria',
            'blood_group' => $validatedData['blood_group'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'place_of_birth' => $validatedData['place_of_birth'],
            'classroom_id' => $classroom->id,
        ];
    }

    /**
     * Get student term results
     *
     *
     * @param  mixed  $student
     * @param  mixed  $termSlug
     * @param  mixed  $academicSessionName
     * @return array
     */
    public static function getTermResults($student, $termSlug, $academicSessionName)
    {
        $academicSession = AcademicSession::where('name', $academicSessionName)->firstOrFail();
        $term = Term::where('slug', $termSlug)->firstOrFail();
        $period = Period::where('academic_session_id', $academicSession->id)->where('term_id', $term->id)->first();

        //Get Classroom
        $result = $student->results()->where('period_id', $period->id)->first();

        if (is_null($result)) {
            throw new Exception('No results found for selected term');
        }

        $classroomId = $result->classroom_id;

        $results = Result::where('student_id', $student->id)->where('period_id', $period->id)->get();

        $maxScores = [];
        $minScores = [];
        $averageScores = [];

        //Get each subject highest and lowest scores
        foreach ($results as $result) {
            $scoresQuery = Result::where('period_id', $period->id)
                ->where('subject_id', $result->subject->id)->where('classroom_id', $classroomId);

            //highest scores
            $maxScore = $scoresQuery->max('total');

            $maxScore = [$result->subject->name => $maxScore];
            $maxScores = array_merge($maxScores, $maxScore);

            //Lowest scores
            $minScore = $scoresQuery->min('total');

            $minScore = [$result->subject->name => $minScore];
            $minScores = array_merge($minScores, $minScore);

            //Average Scores
            $averageScore = $scoresQuery->pluck('total');
            $averageScore = collect($averageScore)->avg();
            $averageScore = [$result->subject->name => $averageScore];
            $averageScores = array_merge($averageScores, $averageScore);
        }

        return compact('student', 'results', 'academicSession', 'term', 'maxScores', 'averageScores', 'minScores', 'period');
    }

    /**
     * show student
     *
     * @param  mixed  $student
     * @return array
     */
    public static function show($student)
    {
        //get results that have unique academic sessions
        $results = Result::where('student_id', $student->id)->get();
        $periods = [];

        foreach ($results as $result) {
            array_push($periods, $result->period);
        }

        $periodsCollection = collect($periods);

        $uniqueAcademicSessions = $periodsCollection->unique('academic_session_id');

        $academicSessions = [];

        foreach ($uniqueAcademicSessions as $uniqueAcademicSession) {
            $academicSession = $uniqueAcademicSession->academicSession;
            array_push($academicSessions, $academicSession);
        }

        $academicSessions = collect($academicSessions);

        $terms = Term::all();
        $activePeriod = Period::activePeriod();

        $guardians = Guardian::all();

        return compact('student', 'academicSessions', 'terms', 'activePeriod', 'guardians');
    }

    public static function getSessionalResults($student, $academicSessionName)
    {
        $academicSession = AcademicSession::where('name', $academicSessionName)->firstOrFail();
        $periods = Period::where('academic_session_id', $academicSession->id)->get();

        $periods = $periods->filter(function ($period) use ($student) {
            $result = $student->results->where('period_id', $period->id)->first();
            if (! is_null($result)) {
                return $period;
            }
        });

        $results = [];
        $maxScores = [];
        $minScores = [];
        $averageScores = [];

        //loop through all the terms and create an associative array based on terms and results
        foreach ($periods as $period) {
            $resultItem = Result::where('student_id', $student->id)
                ->where('period_id', $period->id)->get();

            //Get Classroom
            $classroomId = $student->results()->where('period_id', $period->id)->first()->classroom_id;

            //Get each subject highest and lowest scores
            foreach ($resultItem as $item) {
                $scoresQuery = Result::where('period_id', $period->id)->where('subject_id', $item->subject->id)->where('classroom_id', $classroomId);

                //highest scores
                $maxScore = $scoresQuery->max('total');

                $maxScore = [$item->subject->name.'-'.$period->term->name => $maxScore];
                $maxScores = array_merge($maxScores, $maxScore);

                //Lowest scores
                $minScore = $scoresQuery->min('total');

                $minScore = [$item->subject->name.'-'.$period->term->name => $minScore];
                $minScores = array_merge($minScores, $minScore);

                //Average Scores
                $averageScore = $scoresQuery->pluck('total');

                $averageScore = collect($averageScore)->avg();
                $averageScore = [$item->subject->name.'-'.$period->term->name => $averageScore];
                $averageScores = array_merge($averageScores, $averageScore);
            }

            $resultItem = [$period->term->name => $resultItem];
            $results = array_merge($results, $resultItem);
        }

        return compact('results', 'maxScores', 'minScores', 'averageScores', 'academicSession');
    }

    public static function uploadImage($student, $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'unique:students,image,except,id', 'mimes:jpg', 'max:1000'],
        ]);

        //create name from first and last name
        $imageName = $student->first_name.$student->last_name.'.'.$request->image->extension();
        $path = $request->file('image')->storeAs('public/students', $imageName);
        Image::make($request->image->getRealPath())->fit(400, 400)->save(storage_path('app/'.$path));

        //update image in the database
        $filePath = 'storage/students/'.$imageName;
        $student->image = $filePath;
        $student->save();
    }
}
