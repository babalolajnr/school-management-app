<?php

namespace App\Http\Controllers;

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
     * Mark notification as read
     *
     * @return void
     */
    public function read($notification)
    {
        $user = auth()->user();
        $notification = $user->notifications->where('id', $notification)->markAsRead();

        return response()->json('Success');
    }

    public function inbox()
    {
        return view('notification.inbox');
    }
}
