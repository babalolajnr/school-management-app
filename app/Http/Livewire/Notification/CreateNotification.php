<?php

namespace App\Http\Livewire\Notification;

use App\Models\Teacher;
use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class CreateNotification extends Component
{
    public $title;

    public $content;

    public $notificationType;

    public $to;

    protected $rules = [
        'title' => ['required', 'string', 'max:50'],
        'content' => ['required', 'string'],
        'notificationType' => ['required', 'string'],
        'to' => ['required', 'string'],
    ];

    public function render()
    {
        return view('livewire.notification.create');
    }

    public function mount()
    {
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        $notification = ['title' => $this->title, 'message' => $this->content];

        switch ($this->notificationType) {
            case 'App Notification':
                switch ($this->to) {
                    case 'Admins':
                        $users = User::all();
                        Notification::send($users, new AppNotification($notification));
                        break;

                    case 'Master Users':
                        $users = User::where('user_type', 'master')->get();
                        Notification::send($users, new AppNotification($notification));
                        break;

                    case 'Teachers':
                        $teachers = Teacher::all();
                        Notification::send($teachers, new AppNotification($notification));
                        break;

                    case 'All':
                        $teachers = Teacher::all();
                        $users = User::all();
                        Notification::send($teachers, new AppNotification($notification));
                        Notification::send($users, new AppNotification($notification));
                        break;

                    default:
                        return back()->with('error', 'Recipient not found');
                        break;
                }
                break;

            default:
                // code...
                break;
        }

        $this->emit('success', 'Notification sent');
        $this->reset();
    }
}
