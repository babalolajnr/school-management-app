<?php

namespace App\Http\Controllers;

use App\Models\Branch;
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
        return response(200);
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
        ]);

        Branch::create($data);
        return back()->with('success', 'Branch created!');
    }
    
    /**
     * Edit branch.
     *
     * @param  mixed $branch
     * @return void
     */
    public function edit(Branch $branch)
    {
        return response();
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
        ]);

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
        try {
            $branch->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return back()->with('error', 'Branch can not be deleted because some resources are dependent on it!');
            }
        }
    }
}
