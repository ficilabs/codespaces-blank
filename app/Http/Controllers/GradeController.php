<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::latest()->get();

        return view('backend.grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|unique:grades,name|max:255',
        ]);

        Grade::create([
            'name' => $request->name,
        ]);

        return redirect()->route('grades.index')->with('success', 'Grade berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:grades,name,' . $id,
        ]);

        $grade = Grade::findOrFail($id);
        $grade->update([
            'name' => $request->name,
        ]);

        return redirect()->route('grades.index')->with('success', 'Grade berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grade = Grade::findOrFail($id);

        // Optional: check if this grade is used in classes or students

        $grade->delete();

        return redirect()->route('grades.index')
            ->with('success', 'Grade berhasil dihapus.');
    }
}
