<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DayEntry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DayEntryController extends Controller
{
    public function index(Request $request)
    {
        $entries = $request->user()
            ->dayEntries()
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($entries);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => [
                    'required',
                    'date',
                    Rule::unique('day_entries')->where(function ($query) use ($request) {
                        return $query->where('user_id', $request->user()->id)
                                     ->whereNull('deleted_at'); // soft delete figyelembevétele
                    }),
                ],
                'mood' => 'required|integer|min:1|max:10',
                'weather' => 'nullable|in:Napos,Felhos,Esos,Szeles,Havas',
                'sleep_quality' => 'nullable|in:Nagyon rossz,Rossz,Kozepes,Jo,Kivalo',
                'activity' => 'nullable|in:Munka,Tanulas,Pihenes,Sport,Szorakozas,Egyeb',
                'health_action' => 'nullable|in:Mozgas,Egeszseges etkezes,Pihenes,Semmi',
                'score' => 'nullable|integer|min:1|max:10',
                'note' => 'nullable|string|max:1000',
            ]);

            // Castolás, ha szám mezők
            $validated['mood'] = (int) $validated['mood'];
            if (isset($validated['score'])) {
                $validated['score'] = (int) $validated['score'];
            }

            $entry = $request->user()->dayEntries()->create($validated);

            return response()->json($entry, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Ha ugyanarra a napra már van bejegyzés
            return response()->json([
                'message' => 'Már van bejegyzés az adott napra.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hiba a mentés során.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, DayEntry $dayEntry)
    {
        if ($dayEntry->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return response()->json($dayEntry);
    }

    public function update(Request $request, DayEntry $dayEntry)
    {
        if ($dayEntry->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'mood' => 'sometimes|required|integer|min:1|max:10',
            'weather' => 'nullable|in:Napos,Felhos,Esos,Szeles,Havas',
            'sleep_quality' => 'nullable|in:Nagyon rossz,Rossz,Kozepes,Jo,Kivalo',
            'activity' => 'nullable|in:Munka,Tanulas,Pihenes,Sport,Szorakozas,Egyeb',
            'health_action' => 'nullable|in:Mozgas,Egeszseges etkezes,Pihenes,Semmi',
            'score' => 'nullable|integer|min:1|max:10',
            'note' => 'nullable|string|max:1000',
        ]);

        $dayEntry->update($validated);

        return response()->json($dayEntry);
    }

    public function destroy(Request $request, DayEntry $dayEntry)
    {
        if ($dayEntry->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $dayEntry->delete();

        return response()->json(['message' => 'Entry deleted successfully']);
    }
}
