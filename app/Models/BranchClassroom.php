<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BranchClassroom extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
    
    /**
     * Student relationship
     *
     * @return void
     */
    public function student()
    {
        $this->hasMany(Student::class);
    }
}
