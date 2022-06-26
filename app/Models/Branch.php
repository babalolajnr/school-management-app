<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents an arm of a classroom
 */
class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Classrooms relationship
     *
     * @return void
     */
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class)->using(BranchClassroom::class)->withTimestamps();
    }
}
