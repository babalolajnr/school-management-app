<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeactivatedController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        if ($request->user()->isVerified() && $request->user()->isActive()) {
            return redirect(route('dashboard'));
        } else {
            return view('deactivated');
        }
    }
}
