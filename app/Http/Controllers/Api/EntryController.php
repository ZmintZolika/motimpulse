<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EntryController extends Controller
{
    public function index(Request $request)
    {
        $entries = Entry::where('user_id', $request->user()->user_id)
            ->where('is_deleted', false)
            ->with('quote')
            ->orderBy('entry_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'entries' => $entries,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'          => ['required', 'date'],
            'mood' => ['nullable', Rule::in(['Lehangolt', 'Kiegyensúlyozott', 'Vidám'])],
            'weather' => ['required', Rule::in(['Napos', 'Felhős', 'Esős', 'Szeles', 'Havas'])],
            'sleep_quality' => ['required', Rule::in(['Nagyon rossz', 'Rossz', 'Közepes', 'Jó', 'Kiváló'])],
            'activities' => ['required', Rule::in(['Munka', 'Tanulás', 'Pihenés', 'Sport', 'Szórakozás', 'Egyéb'])],
            'health_action' => ['required', Rule::in(['Mozgás', 'Egészséges étkezés', 'Pihenés', 'Semmi'])],
            'score'         => ['nullable', 'integer', 'min:1', 'max:10'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        if (!empty($validated['mood'])) {
            $quote = Quote::where('quote_category', $validated['mood'])
                ->inRandomOrder()
                ->first();
            
            if (!$quote) {
                $quote = Quote::inRandomOrder()->first();
            }
        } else {
            $quote = Quote::inRandomOrder()->first();
        }

        $entry = Entry::create([
            'user_id' => $request->user()->user_id,
            'quote_id' => $quote ? $quote->quote_id : null,
            'entry_date'    => $validated['date'],
            'mood' => $validated['mood'] ?? null,
            'weather' => $validated['weather'],
            'sleep_quality' => $validated['sleep_quality'],
            'activities' => $validated['activities'],
            'health_action' => $validated['health_action'],
            'score'         => $validated['score'] ?? null,
            'note' => $validated['note'] ?? null,
            'is_deleted' => false,
        ]);

        return response()->json([
            'message' => 'Entry sikeresen létrehozva',
            'entry' => $entry->load('quote'), 
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $entry = Entry::where('entry_id', $id)
            ->where('user_id', $request->user()->user_id)
            ->where('is_deleted', false)
            ->with('quote')
            ->first();

        if (!$entry) {
            return response()->json([
                'message' => 'Entry nem található',
            ], 404);
        }

        return response()->json([
            'entry' => $entry,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $entry = Entry::where('entry_id', $id)
            ->where('user_id', $request->user()->user_id)
            ->where('is_deleted', false)
            ->first();

        if (!$entry) {
            return response()->json([
                'message' => 'Entry nem található',
            ], 404);
        }

        $validated = $request->validate([
            'entry_date'     => ['required', 'date'], 
            'mood'           => ['nullable', Rule::in(['Lehangolt', 'Kiegyensúlyozott', 'Vidám'])],
            'weather'        => ['sometimes', Rule::in(['Napos', 'Felhős', 'Esős', 'Szeles', 'Havas'])],
            'sleep_quality'  => ['sometimes', Rule::in(['Nagyon rossz', 'Rossz', 'Közepes', 'Jó', 'Kiváló'])],
            'activities'     => ['sometimes', Rule::in(['Munka', 'Tanulás', 'Pihenés', 'Sport', 'Szórakozás', 'Egyéb'])],
            'health_action'  => ['sometimes', Rule::in(['Mozgás', 'Egészséges étkezés', 'Pihenés', 'Semmi'])],
            'score'          => ['sometimes', 'nullable', 'integer', 'min:1', 'max:10'],
            'note'           => ['nullable', 'string', 'max:1000'],
        ]); 

        // Quote frissítése mood változásnál
        if (array_key_exists('mood', $validated) && $validated['mood'] !== $entry->mood) {
            if (!empty($validated['mood'])) {
                $quote = Quote::where('quote_category', $validated['mood'])
                    ->inRandomOrder()
                    ->first();
            } else {
                $quote = Quote::inRandomOrder()->first();
            }
            $entry->quote_id = $quote ? $quote->quote_id : null;
        }

        $entry->update(array_filter($validated, function($value) {
            return $value !== null;
        }));

        return response()->json([
            'message' => 'Entry frissítve',
            'entry'   => $entry->load('quote'), 
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $entry = Entry::where('entry_id', $id)
            ->where('user_id', $request->user()->user_id)
            ->where('is_deleted', false)
            ->first();

        if (!$entry) {
            return response()->json([
                'message' => 'Entry nem található',
            ], 404);
        }

        $entry->update(['is_deleted' => true]);
        $entry->delete(); 

        return response()->json([
            'message' => 'Entry sikeresen törölve',
        ], 200);
    }
}
