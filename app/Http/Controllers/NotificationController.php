<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Models\Teacher;
use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    /**
     * Index
     *
     * @return  \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('notification.create');
    }

    /**
     * Store notification
     *
     * @param  NotificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NotificationRequest $request)
    {
        $data = $request->validated();

        $notification = ["title" => $data['title'], "message" => $data['message']];

        switch ($data['notification-type']) {
            case 'App Notification':
                switch ($data['to']) {
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
                # code...
                break;
        }
        return back()->with('success', 'Notification sent');
    }

    /**
     * Mark notification as read
     *
     * @return void
     */
    public function read($notification)
    {
        $user = auth()->user();
        $notification = $user->notifications->where('id', $notification)->markAsRead();
        return response()->json("Success");
    }

    public function inbox()
    {
        return view('notification.inbox');
    }
}
