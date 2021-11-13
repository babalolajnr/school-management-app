<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchClassroom;
use App\Models\Teacher;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    /**
     * View branches
     *
     * @return void
     */
    public function index()
    {
        $branches = Branch::all();
        return view('branch.index', compact('branches'));
    }

    /**
     * Store branch
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:branches']
        ], ['name.unique' => 'Name exists']);

        Branch::create($data);
        return back()->with('success', 'Branch created!');
    }

    /**
     * Edit branch.
     *
     * @param  Branch $branch
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Branch $branch)
    {
        return view('branch.edit', compact('branch'));
    }

    /**
     * Update branch
     *
     * @param  Branch $branch
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Branch $branch, Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:branches']
        ], ['name.unique' => 'Name exists']);

        $branch->update($data);
        return back()->with('success', 'Branch updated!');
    }

    /**
     * Delete branch
     *
     * @param  Branch $branch
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Branch $branch)
    {
        if ($branch->classrooms->count() > 0) return back()->with('error', 'Branch can not be deleted because some resources are dependent on it!');
        $branch->delete();
        return back()->with('success', 'Branch deleted');
    }

    /**
     * Assign teachers to classroom branch
     *
     * @param  BranchClassroom $branchClassroom
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignTeachers(BranchClassroom $branchClassroom, Request $request)
    {
        $teachers = $request->teachers;

        foreach ($teachers as $teacher) {

            // Validate if all the selected teachers exist
            if (!Teacher::where('slug', $teacher)->exists()) {
                return back()->with('error', "Teacher $teacher does not exist");
            }
        }

        $teachers = collect($teachers);

        $teachers->map(function ($teacher) use ($branchClassroom) {
            $teacher = Teacher::where('slug', $teacher)->first();

            $teacher->branch_classroom_id = $branchClassroom->id;
            $teacher->save();
        });

        return back()->with('success', 'Teachers assigned to classroom');
    }
}
