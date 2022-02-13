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
    public $deleteItem;

    protected $listeners = ['delete'];

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

    public function delete()
    {
        $academicSession = AcademicSession::whereName($this->deleteItem)->first();

        try {
            $academicSession->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return $this->emit('error', 'Academic session can not be deleted because some resources are dependent on it!');
            }
        }

        $this->emit('success', 'Academic session deleted!');
        $this->academicSessions = AcademicSession::all();
    }
}
