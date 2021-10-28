<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Models\Teacher;
use App\Models\User;
use App\Notifications\AppNotification;

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
                User::all()->map(function ($user) use ($notification) {
                    $user->notify(new AppNotification($notification));
                });
            } elseif ($recipients == 'Master Users') {
                User::where('user_type', 'master')->get()->map(function ($user) use ($notification) {
                    $user->notify(new AppNotification($notification));
                });
            } elseif ($recipients == 'Teachers') {
                Teacher::all()->map(function ($teacher) use ($notification) {
                    $teacher->notify(new AppNotification($notification));
                });
            } elseif ($recipients == 'All') {
                
                Teacher::all()->map(function ($teacher) use ($notification) {
                    $teacher->notify(new AppNotification($notification));
                });
                User::all()->map(function ($user) use ($notification) {
                    $user->notify(new AppNotification($notification));
                });
            }

            return back()->with('success', 'Notification sent');
        }
    }
}
