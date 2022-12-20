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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'branch_classroom_id');
    }

    /**
     * Teachers relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'branch_classroom_id');
    }

    /**
     * Classroom relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Branch relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get Main Teacher
     *
     * @return App\Models\Teacher
     */
    public function mainTeacher()
    {
        return Teacher::where('id', $this->teacher_id)->first();
    }

      /**
     * Get Active Students of a classroom
     *
     * @return mixed
     */
    public function activeStudents()
    {
        return $this->students->whereNull('graduated_at')->where('is_active', true)->all();
    }
}
