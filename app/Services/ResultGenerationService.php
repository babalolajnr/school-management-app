<?php

namespace App\Services;

use App\Models\ADType;
use App\Models\Classroom;
use App\Models\Fee;
use App\Models\PDType;
use App\Models\Period;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TeacherRemark;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Service class for result generation
 */
class ResultGenerationService
{

    public function __construct(private Student $student, private Period $period)
    {
    }

    /**
     * generate Report
     */
    public function generateReport(): array
    {
        $classroom = $this->getClassroom();
        
        //Get the subjects for the student's class in the selected period Academic Session
        $subjects = $this->getPeriodSubjects($classroom);
        $attendance = $this->student->attendances()->where('period_id', $this->period->id)->first();

        /**
         * Check if the class has subjects
         * Classroom's academic session subjects are needed to generate report
         */
        if (count($subjects) < 1) {
            throw new Exception("Student's class does not have subjects");
        }

        $results = $this->getSubjectResults($subjects);

        $teacherRemark = TeacherRemark::where('student_id', $this->student->id)->where('period_id', $this->period->id)->first();

        $totalObtained = $results->sum('total');
        $totalObtainable = $subjects->count() * 100;
        return [
            'student' => $this->student,
            'totalObtained' => $totalObtained,
            'totalObtainable' => $totalObtainable,
            'percentage' => $totalObtained / $totalObtainable * 100,
            'results' => $results,
            'maxScores' => $this->getMaxScores($results),
            'averageScores' => $this->getAvgScores($results),
            'minScores' => $this->getMinScores($results),
            'age' => $this->student->age(),
            'pds' => $this->getPds(),
            'pdTypes' => PDType::all(),
            'ads' => $this->getAds(),
            'adTypes' => ADType::all(),
            'period' => $this->period,
            'nextTermBegins' => $this->getNextTermDetails()['nextTermBegins'],
            // 'nextTermFee' => $nextTermDetails['nextTermFee'],
            'teacherRemark' => $teacherRemark,
            'classroom' => $classroom,
            'no_of_times_present' => $attendance,
        ];
    }

    private function getMinScores(Collection $results): Collection
    {
        return $results->mapWithKeys(function (Result $result) {
            $key = $result->subject->name;

            if (!$result) {
                return [$key => null];
            }

            $scoresQuery = Result::where('period_id', $this->period->id)
                ->where('subject_id', $result->subject_id)
                ->where('classroom_id', $result->classroom_id);

            $maxScore = $scoresQuery->min('total');

            return [$key => $maxScore];
        });
    }

    private function getMaxScores(Collection $results): Collection
    {
        return $results->mapWithKeys(function (Result $result) {
            $key = $result->subject->name;

            if (!$result) {
                return [$key => null];
            }

            $scoresQuery = Result::where('period_id', $this->period->id)
                ->where('subject_id', $result->subject_id)
                ->where('classroom_id', $result->classroom_id);

            $minScore = $scoresQuery->max('total');

            return [$key => $minScore];
        });
    }

    private function getAvgScores(Collection $results): Collection
    {
        return $results->mapWithKeys(function (Result $result) {
            $key = $result->subject->name;

            if (!$result) {
                return [$key => null];
            }

            $scoresQuery = Result::where('period_id', $this->period->id)
                ->where('subject_id', $result->subject_id)
                ->where('classroom_id', $result->classroom_id);

            $averageScore = $scoresQuery->pluck('total');
            $averageScore = collect($averageScore)->avg();

            return [$key => $averageScore];
        });
    }

    /**
     * Get Psychomotor domains for a given period
     */
    private function getPds(): array
    {
        // get pds for the period
        $pds = $this->student->pds()->where('period_id', $this->period->id)->get();

        $pdTypeIds = [];
        $values = [];

        //for each of the pds push the pdTypeId and pd value into two separate arrays
        foreach ($pds as $pd) {
            $pdTypeId = $pd->p_d_type_id;
            array_push($pdTypeIds, $pdTypeId);
            array_push($values, $pd->value);
        }

        //for each pdTypeId get the name and push it into an array
        $pdTypeNames = [];
        foreach ($pdTypeIds as $pdTypeId) {
            $pdTypeName = PDType::find($pdTypeId)->name;
            array_push($pdTypeNames, $pdTypeName);
        }

        //combine the values array and the names array to form a new associative pds array
        $pds = array_combine($pdTypeNames, $values);

        return $pds;
    }

    /**
     * Get Affective domains for given period
     *
     * @param  Period  $period
     * @return array
     */
    private function getAds(): array
    {
        // get ads for period
        $ads = $this->student->ads()->where('period_id', $this->period->id)->get();

        $adTypeIds = [];
        $values = [];

        //for each of the ads push the adTypeId and pd value into two separate arrays
        foreach ($ads as $ad) {
            $adTypeId = $ad->a_d_type_id;
            array_push($adTypeIds, $adTypeId);
            array_push($values, $ad->value);
        }

        //for each adTypeId get the name and push it into an array
        $adTypeNames = [];
        foreach ($adTypeIds as $adTypeId) {
            $adTypeName = ADType::find($adTypeId)->name;
            array_push($adTypeNames, $adTypeName);
        }

        //comnine the values array and the names array to form a new associative ads array
        $ads = array_combine($adTypeNames, $values);

        return $ads;
    }

    /**
     * Get next term details
     */
    private function getNextTermDetails(): array
    {
        $nextPeriod = Period::where('rank', $this->period->rank + 1)->first();

        if (is_null($nextPeriod)) {
            $nextTermBegins = null;
            // $nextTermFee = null;
        } else {
            $nextTermBegins = $nextPeriod->start_date;
            // $nextTermFee = Fee::where('classroom_id', $this->student->classroom->id)
            //     ->where('period_id', $nextPeriod->id)->first();

            // //check if next term fee is available
            // if (is_null($nextTermFee)) {
            //     $nextTermFee = null;
            // } else {
            //     $nextTermFee = number_format($nextTermFee->amount);
            // }
        }

        return [
            'nextTermBegins' => $nextTermBegins,
            // 'nextTermFee' => $nextTermFee
        ];
    }

    private function getPeriodSubjects(Classroom $classroom): Collection
    {
        //Get the subjects for the student's class in the selected period's Academic Session
        $classroom_subjects = DB::table('classroom_subject')
            ->where('academic_session_id', $this->period->academicSession->id)
            ->where('classroom_id', $classroom->id)
            ->get();

        return $classroom_subjects->map(function ($subject) {
            return Subject::find($subject->subject_id);
        });
    }

    /**
     * Get the classroom for the student in the selected period
     */
    private function getClassroom(): Classroom
    {
        return $this->student->results()->where('period_id', $this->period->id)->firstOrFail()->classroom;
    }

    private function getSubjectResults(Collection $subjects): Collection
    {
        return $subjects->mapWithKeys(function (Subject $subject) {
            return [
                $subject->name => Result::with('subject')->where('student_id', $this->student->id)
                    ->where('period_id', $this->period->id)->where('subject_id', $subject->id)->first()
            ];
        });
    }
}