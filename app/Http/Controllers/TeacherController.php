<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UserTeacherUpdateRequest;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use  Intervention\Image\Facades\Image;

class TeacherController extends Controller
{
    /**
     * Generate full name slug
     *
     * @param  string  $firstName
     * @param  string  $lastName
     * @return \Illuminate\Support\Stringable
     */
    private function generateFullNameSlug($firstName, $lastName)
    {
        $fullname = $firstName.' '.$lastName.' '.Str::random(5);
        $slug = Str::of($fullname)->slug('-');

        return $slug;
    }

    /**
     * Show teachers page
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $teachers = Teacher::all();
        $teachers->map(function ($teacher) {
            if ($teacher->last_seen) {
                $lastSeen = $teacher->last_seen;

                // convert to carbon instance
                $lastSeen = Carbon::createFromFormat('Y-m-d H:i:s', $lastSeen);

                // Convert to human diff format
                $lastSeen = $lastSeen->diffForHumans();

                $teacher->last_seen = $lastSeen;
            }
        });

        return view('teacher.index', compact('teachers'));
    }

    /**
     * Show create teacher page
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('teacher.create');
    }

    /**
     * Store new teacher
     *
     * @param  StoreTeacherRequest  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreTeacherRequest $request)
    {
        $validated = $request->validated();

        $slug = $this->generateFullNameSlug($validated['first_name'], $validated['last_name']);

        $password = bcrypt($validated['last_name']);

        $data = array_merge($validated, ['slug' => $slug], ['password' => $password]);

        Teacher::create($data);

        return redirect()->route('teacher.index')->with('success', 'Teacher Created');
    }

    /**
     * Show teacher
     *
     * @param  Teacher  $teacher
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Teacher $teacher)
    {
        return view('teacher.show', compact('teacher'));
    }

    /**
     * Show edit teacher view.
     *
     * @param  Teacher  $teacher
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Teacher $teacher)
    {
        return view('teacher.edit', compact('teacher'));
    }

    /**
     * User teacher update
     *
     * Only users authenticated with the web guard can use this method
     *
     * @param  Teacher  $teacher
     * @param  UserTeacherUpdateRequest  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function userTeacherUpdate(Teacher $teacher, UserTeacherUpdateRequest $request)
    {
        $validatedData = $request->validated();

        //check if either the first or last name has changed to generate a new slug
        if ($teacher->first_name != $validatedData['first_name'] || $teacher->last_name != $validatedData['last_name']) {
            $slug = $this->generateFullNameSlug($validatedData['first_name'], $validatedData['last_name']);
            $data = array_merge($validatedData, ['slug' => $slug]);
        } else {
            $data = $validatedData;
        }

        $teacher->update($data);

        return redirect()->route('teacher.edit', ['teacher' => $teacher])->with('success', 'Teacher Updated!');
    }

    /**
     * Update Teacher
     *
     * @param  Teacher  $teacher
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Teacher $teacher, Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
            'sex' => ['required', 'string'],
        ]);

        if ($teacher->first_name != $validatedData['first_name'] || $teacher->last_name != $validatedData['last_name']) {
            $slug = $this->generateFullNameSlug($validatedData['first_name'], $validatedData['last_name']);
            $data = array_merge($validatedData, ['slug' => $slug]);
        } else {
            $data = $validatedData;
        }

        $teacher->update($data);

        return redirect()->route('teacher.edit', ['teacher' => $teacher])->with('success', 'Teacher Updated!');
    }

    /**
     * Activate teacher
     *
     * @param  Teacher  $teacher
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function activate(Teacher $teacher)
    {
        $teacher->is_active = true;
        $teacher->save();

        return redirect()->back()->with('success', 'Teacher Activated!');
    }

    /**
     * Deactivate teacher
     *
     * @param  Teacher  $teacher
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function deactivate(Teacher $teacher)
    {
        $teacher->is_active = false;
        $teacher->save();

        return redirect()->back()->with('success', 'Teacher Deactivated!');
    }

    /**
     * delete teacher
     *
     * @param  Teacher  $teacher
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->back()->with('success', 'Teacher Deleted!');
    }

    /**
     * store teacher Signature
     *
     * @param  Teacher  $teacher
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSignature(Teacher $teacher, Request $request)
    {
        $this->authorize('storeSignature', $teacher);

        $request->validate([
            'signature' => ['required', 'image', 'unique:teachers,signature,except,id', 'mimes:jpg', 'max:1000'],
        ]);

        //create name from first and last name
        $signatureName = $teacher->first_name.$teacher->last_name.'.'.$request->signature->extension();
        $path = $request->file('signature')->storeAs('public/teachers/signatures', $signatureName);
        Image::make($request->signature->getRealPath())->fit(400, 400)->save(storage_path('app/'.$path));

        //update signature in the database
        $filePath = 'storage/teachers/signatures/'.$signatureName;
        $teacher->signature = $filePath;
        $teacher->save();

        return back()->with('success', 'Signature uploaded successfully');
    }

    /**
     * Update password.
     *
     * @param  Request  $request
     * @param  Teacher  $teacher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request, Teacher $teacher)
    {
        $this->authorize('updatePassword', $teacher);

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'confirmed', 'min:8'],
        ]);

        //if password does not match the current password
        if (! Hash::check($data['current_password'], $teacher->password)) {
            throw ValidationException::withMessages(['current_password' => ['Password does not match current password']]);
        }

        $teacher->password = bcrypt($data['new_password']);
        $teacher->save();

        return redirect()->back()->with('success', 'Password updated!');
    }

    /**
     * Show deleted teachers
     *
     * @return \Illuminate\View\View
     */
    public function showTrashed()
    {
        $teachers = Teacher::onlyTrashed()->get();

        return view('teacher.trash', compact('teachers'));
    }

    /**
     * Restore deleted teacher
     *
     * @param  mixed  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $teacher = Teacher::withTrashed()->findOrFail($id);
        $teacher->restore();

        return back()->with('success', 'Teacher restored!');
    }

    /**
     * Force delete teacher from database
     *
     * @param  mixed  $id
     * @param  Teacher  $teacher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id, Teacher $teacher)
    {
        $teacher = Teacher::withTrashed()->findOrFail($id);

        //delete teacher signature if it exists
        if (! is_null($teacher->signature)) {
            $deletePath = $teacher->signature;
            $deletePath = str_replace('storage/', '', $deletePath);
            $deletePath = 'public/'.$deletePath;

            Storage::delete($deletePath);
        }

        $teacher->forceDelete();

        return back()->with('success', 'Teacher deleted permanently');
    }
}
