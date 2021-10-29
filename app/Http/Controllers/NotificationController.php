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
        return view('notifications');
    }

    public function store(NotificationRequest $request)
    {
        $data = $request->validated();

        if ($data['notification-type'] == 'App Notification') {
            $recipients = $data['to'];
            $notification = ["title" => $data['title'], "message" => $data['message']];

            if ($recipients == 'Admins') {

                $users = User::all();
                Notification::send($users, new AppNotification($notification));
            } elseif ($recipients == 'Master Users') {

                $users = User::where('user_type', 'master')->get();
                Notification::send($users, new AppNotification($notification));
            } elseif ($recipients == 'Teachers') {

                $teachers = Teacher::all();
                Notification::send($teachers, new AppNotification($notification));
            } elseif ($recipients == 'All') {

                $teachers = Teacher::all();
                $users = User::all();
                Notification::send($teachers, new AppNotification($notification));
                Notification::send($users, new AppNotification($notification));
            }

            return back()->with('success', 'Notification sent');
        }
    }
}
