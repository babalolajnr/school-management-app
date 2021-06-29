<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTeacherSettings extends Model
{
    use HasFactory;

    protected $table = 'user_teacher_settings';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
