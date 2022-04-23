<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidateDateRangeTest extends TestCase
{
    use ValidationTrait;
    use RefreshDatabase;

    public function test_two_dates_that_overlap_returns_true()
    {
        $startDate = '2020-01-01';
        $endDate = '2020-01-02';

        AcademicSession::create([
            'name' => '2020-2020',
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $this->assertTrue($this->dateOverlaps($startDate, $endDate, AcademicSession::class));
    }

    public function test_two_dates_that_overlap_returns_true_with_model_passed_in()
    {
        $academicSession = AcademicSession::create([
            'name' => '2020-2020',
            'start_date' => '2020-01-01',
            'end_date' => '2020-01-02'
        ]);

        $startDate = '2019-01-01';
        $endDate = '2019-01-02';

        AcademicSession::create([
            'name' => '2019-2019',
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $this->assertTrue($this->dateOverlaps($startDate, $endDate, AcademicSession::class, $academicSession));
    }

    public function test_overlap_is_ignored_when_model_is_passed_in()
    {


        $startDate = '2019-01-01';
        $endDate = '2019-01-02';

        $academicSession = AcademicSession::create([
            'name' => '2019-2019',
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $this->assertFalse($this->dateOverlaps($startDate, $endDate, AcademicSession::class, $academicSession));
    }

    public function test_two_dates_that_do_not_overlap_returns_false()
    {
        $startDate = '2020-01-01';
        $endDate = '2020-01-02';

        AcademicSession::create([
            'name' => '2020-2020',
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $this->assertFalse($this->dateOverlaps('2020-01-03', '2020-01-04', AcademicSession::class));
    }

    public function test_date_that_false_in_the_middle_of_another_date_returns_true()
    {
        $startDate = '2020-01-01';
        $endDate = '2020-01-02';

        AcademicSession::create([
            'name' => '2020-2020',
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $this->assertTrue($this->dateOverlaps('2020-01-01', '2020-01-03', AcademicSession::class));
    }

    public function test_academic_session_that_overlaps_itself_returns_false()
    {
        $startDate = '2020-01-01';
        $endDate = '2020-01-02';

        $academicSession = AcademicSession::create([
            'name' => '2020-2020',
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $this->assertFalse($this->dateOverlaps($startDate, $endDate, AcademicSession::class, $academicSession));
    }
}
