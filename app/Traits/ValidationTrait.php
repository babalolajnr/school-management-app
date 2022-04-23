<?php

namespace App\Traits;

use Carbon\Carbon;

trait ValidationTrait
{

    /**
     * Validate input date overlaps does not
     * overlap other date ranges
     *
     * For Two Date ranges A and B
     * Formula : StartA <= EndB && EndA >= StartB
     *
     * If the function returns true, input date overlaps
     * else it does not
     *
     * @param  string $startDate
     * @param  string $endDate
     * @param string $model
     * @param object $ignore
     * @return bool
     */
    private function dateOverlaps(string $startDate, string $endDate, string $model, object $ignore = null): bool
    {
        $records = $model::all();

        if (count($records) < 1) return false;

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate);

        foreach ($records as $record) {

            //ignore given record
            if ($record->id == $ignore?->id) continue;

            $recordStartDate =  Carbon::createFromFormat('Y-m-d', $record->start_date);
            $recordEndDate =  Carbon::createFromFormat('Y-m-d', $record->end_date);

            if ($recordStartDate->lessThanOrEqualTo($endDate) && $recordEndDate->greaterThanOrEqualTo($startDate)) return true;
        }
        
        return false;
    }
}
