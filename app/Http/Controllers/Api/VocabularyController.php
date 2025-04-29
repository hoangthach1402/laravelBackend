<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    /**
     * Display a listing of vocabularies
     */
    public function index()
    {
        return Vocabulary::all();
    }

    /**
     * Store a newly created vocabulary
     */
    public function store(Request $request)
    {
        $request->validate([
            'english' => 'required|string|max:255',
            'vietnamese' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'image_url' => 'nullable|url'
        ]);

        return Vocabulary::create($request->all());
    }

    /**
     * Display the specified vocabulary
     */
    public function show(Vocabulary $vocabulary)
    {
        return $vocabulary;
    }

    /**
     * Update the specified vocabulary
     */
    public function update(Request $request, Vocabulary $vocabulary)
    {
        $request->validate([
            'english' => 'sometimes|string|max:255',
            'vietnamese' => 'sometimes|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'image_url' => 'nullable|url'
        ]);

        $vocabulary->update($request->all());
        return $vocabulary;
    }

    /**
     * Remove the specified vocabulary
     */
    public function destroy(Vocabulary $vocabulary)
    {
        $vocabulary->delete();
        return response()->noContent();
    }
}