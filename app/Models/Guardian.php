<?php

namespace App\Models;

use App\Notifications\GuardianResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guardian extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, PasswordsCanResetPassword;

    /**
     * The attributes that are not mass assignable
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Student relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Send Password reset notification
     *
     * @param  mixed  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $notification = new GuardianResetPassword($token);

        $this->notify($notification);
    }
}
