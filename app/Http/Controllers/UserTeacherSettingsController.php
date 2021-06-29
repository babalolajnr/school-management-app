<?php

namespace App\Http\Controllers;

use App\Models\UserTeacherSettings;
use Illuminate\Http\Request;

class UserTeacherSettingsController extends Controller
{
    public function toggleDarkMode(Request $request)
    {
        if ($request->darkmode == 'true') {
            $darkmode = true;
        } else {
            $darkmode = false;
        }

        if (auth('web')->check()) {
            UserTeacherSettings::updateOrCreate(
                ['user_id' => auth('web')->user()->id],
                [
                    'dark_mode' => $darkmode,
                    'teacher_id' => null
                ]
            );

            return response()->json(['status' => 'success', 'darkmode' => $darkmode]);
        } else {
            UserTeacherSettings::updateOrCreate(
                ['teacher_id' => auth('teacher')->user()->id],
                [
                    'dark_mode' => $darkmode,
                    'user_id' => null
                ]
            );

            return response()->json(['status' => 'success', 'darkmode' => $darkmode]);
        };
    }
}
