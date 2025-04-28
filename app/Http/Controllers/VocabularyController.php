<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vocabularies = Vocabulary::latest()->paginate(10);
        return view('vocabularies.index', compact('vocabularies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vocabularies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'english' => 'required|string|max:255',
            'vietnamese' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:255',
        ]);

        Vocabulary::create($request->all());

        return redirect()->route('vocabularies.index')
            ->with('success', 'Từ vựng đã được thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vocabulary $vocabulary)
    {
        return view('vocabularies.show', compact('vocabulary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vocabulary $vocabulary)
    {
        return view('vocabularies.edit', compact('vocabulary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vocabulary $vocabulary)
    {
        $request->validate([
            'english' => 'required|string|max:255',
            'vietnamese' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:255',
        ]);

        $vocabulary->update($request->all());

        return redirect()->route('vocabularies.index')
            ->with('success', 'Từ vựng đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vocabulary $vocabulary)
    {
        $vocabulary->delete();

        return redirect()->route('vocabularies.index')
            ->with('success', 'Từ vựng đã được xóa thành công.');
    }
}
