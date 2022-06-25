<?php

namespace App\Http\Controllers;

use App\Models\ADType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ADTypeController extends Controller
{
    private function validateADType($request, $adType = null)
    {
        return $request->validate([
            'name' => ['required', 'string', Rule::unique('a_d_types', 'name')->ignore($adType)],
        ]);
    }

    public function index()
    {
        $adTypes = ADType::all();

        return view('ad-type.index', compact('adTypes'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateADType($request);

        $validatedData['slug'] = Str::of($validatedData['name'])->slug('-');

        ADType::create($validatedData);

        return back()->with('success', 'Affective Domain created!');
    }

    public function edit(ADType $adType)
    {
        return view('ad-type.edit', compact('adType'));
    }

    public function update(ADType $adType, Request $request)
    {
        $validatedData = $this->validateADType($request, $adType);
        $validatedData['slug'] = Str::of($validatedData['name'])->slug('-');

        $adType->update($validatedData);

        return redirect()->route('ad-type.index')->with('success', 'Affective domain type updated');
    }

    public function destroy(ADType $adType)
    {
        try {
            $adType->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return back()->with('error', 'Affective Domain Type cannot be deleted because some resources are dependent on it!');
            }
        }

        return back()->with('success', 'Deleted!');
    }
}
