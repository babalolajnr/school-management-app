<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rank', 'slug'];

    /**
     * Subjects relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withPivot('academic_session_id')->withTimestamps();
    }

    /**
     * Students relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Teacher relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Fee relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fee()
    {
        return $this->hasMany(Fee::class);
    }

    /**
     * Get Active Students of a classroom
     *
     * @return mixed
     */
    public function getActiveStudents()
    {
        return $this->students->whereNull('graduated_at')->filter(function ($student) {
            return $student->isActive();
        });
    }
    
    /**
     * Count students
     *
     * @return int
     */
    public function countStudents()
    {
       return $this->students->whereNull('graduated_at')->where('is_active', true)->count();
    }
}
