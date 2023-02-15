<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Table associated with Period model
     *
     * @var string
     */
    protected $table = 'periods';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'slug' => 'string',
    ];

    /**
     * Fee relationship
     */
    public function fee(): HasMany
    {
        return $this->hasMany(Fee::class);
    }

    /**
     * Attendance relationship
     */
    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Term relationship
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * AcademicSession relationship
     */
    public function academicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class);
    }

    /**
     * Results relationship
     */
    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Pds relationship
     */
    public function pds(): HasMany
    {
        return $this->hasMany(PD::class);
    }

    /**
     * Teacher Remarks relationship
     */
    public function teacherRemarks(): HasMany
    {
        return $this->hasMany(TeacherRemark::class);
    }

    /**
     * Checks if period is active
     */
    public function isActive(): bool
    {
        return $this->active == true;
    }

    /**
     * Get active period
     */
    public static function activePeriod(): Period
    {
        return Period::whereActive(true)->first();
    }

    /**
     * check if active period is set
     */
    public static function activePeriodIsSet(): bool
    {
        return Period::activePeriod() ? true : false;
    }

    /**
     * check if active period is not set
     */
    public static function activePeriodIsNotSet(): bool
    {
        return !Period::activePeriodIsSet();
    }

    /**
     * Get current academic session
     *
     */
    public static function currentAcademicSession(): AcademicSession|null
    {
        return Period::activePeriod()?->academicSession;
    }

    /**
     * Get current term
     */
    public static function currentTerm(): Term|null
    {
        return Period::activePeriod()?->term;
    }

    public function resultsPublished(): bool {
        return $this->results_published_at != null;
    }

    public static function publishedResultsPeriods(): Collection
    {
        return Period::with(['academicSession', 'term'])->whereNotNull('results_published_at')->get();
    }
}