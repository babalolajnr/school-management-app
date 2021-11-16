<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TeacherLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.teacher.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\TeacherLoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TeacherLoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $teachersClassroom = $request->user('teacher')->branchClassroom;

        if (is_null($teachersClassroom)) { 
            auth('teacher')->logout();
            return route('deactivated');
        }

        return redirect(route('classroom.show.branch', ['classroom' => $teachersClassroom?->classroom, 'branch' => $teachersClassroom?->branch]))->with('success', "Welcome {$request->user('teacher')->first_name} {$request->user('teacher')->last_name}");
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        Auth::guard('teacher')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
