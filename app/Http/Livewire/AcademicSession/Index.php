<?php

namespace App\Http\Livewire\AcademicSession;

use App\Models\AcademicSession;
use App\Traits\ValidationTrait;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Index extends Component
{
    use ValidationTrait;

    public $academicSessions;
    public $startDate;
    public $endDate;
    public $name;

    protected $rules = [
        'name' => ['required', 'string', 'unique:academic_sessions', 'regex:/^\d{4}[-]{1}\d{4}$/m'],
        'startDate' => ['required', 'date', 'unique:academic_sessions,start_date'],
        'endDate' => ['required', 'date', 'unique:academic_sessions,end_date', 'after:startDate']
    ];

    protected $messages = [
        'name.required' => 'This field is required',
        'name.unique' => 'Record exists',
        'name.regex' => 'Academic session format is invalid'
    ];


    public function render()
    {
        return view('livewire.academic-session.index');
    }

    public function mount()
    {
        $this->academicSessions = AcademicSession::all();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {

        $this->validate();

        //check if date range is unique
        $validateDateRange = $this->validateDateRange($this->startDate, $this->endDate, AcademicSession::class);

        //if date range is not unique
        $validateDateRange ? null : throw ValidationException::withMessages([
            'startDate' => ['Date range overlaps with another period'],
            'endDate' => ['Date range overlaps with another period']
        ]);

        AcademicSession::create([
            'name' => $this->name,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);

        $this->emit('success', 'Academic Session Created!');
        $this->academicSessions = AcademicSession::all();
    }
}
