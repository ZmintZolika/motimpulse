<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EntryController extends Controller
{
    /**
     * Összes entry lekérése (bejelentkezett user)
     * GET /api/entries
     */
    public function index(Request $request)
    {
        // Csak a bejelentkezett user entry-jei
        $entries = Entry::where('user_id', $request->user()->user_id)
            ->where('is_deleted', false)
            ->with('quote')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'entries' => $entries,
        ], 200);
    }

        /**
     * Új entry létrehozása
     * POST /api/entries
     */
    public function store(Request $request)
    {
        // Validáció - mood NULLABLE
        $validated = $request->validate([
            'mood' => ['nullable', Rule::in(['Lehangolt', 'Kiegyensúlyozott', 'Vidám'])],
            'weather' => ['required', Rule::in(['Napos', 'Felhős', 'Esős', 'Szeles', 'Havas'])],
            'sleep_quality' => ['required', Rule::in(['Nagyon rossz', 'Rossz', 'Közepes', 'Jó', 'Kiváló'])],
            'activities' => ['required', Rule::in(['Munka', 'Tanulás', 'Pihenés', 'Sport', 'Szórakozás', 'Egyéb'])],
            'health_action' => ['required', Rule::in(['Mozgás', 'Egészséges étkezés', 'Pihenés', 'Semmi'])],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        // Quote generálás
        if (isset($validated['mood'])) {
            // Ha mood megadva → mood szerint random quote
            $quote = Quote::where('mood', $validated['mood'])
                ->inRandomOrder()
                ->first();
        } else {
            // Ha mood NINCS megadva → random quote az egész táblából
            $quote = Quote::inRandomOrder()->first();
        }

        // Entry létrehozása
        $entry = Entry::create([
            'user_id' => $request->user()->user_id,
            'quote_id' => $quote ? $quote->quote_id : null,
            'mood' => $validated['mood'] ?? null,
            'weather' => $validated['weather'],
            'sleep_quality' => $validated['sleep_quality'],
            'activities' => $validated['activities'],
            'health_action' => $validated['health_action'],
            'note' => $validated['note'] ?? null,
            'is_deleted' => false,
        ]);

        $entry->load('quote');

        return response()->json([
            'message' => 'Entry sikeresen létrehozva',
            'entry' => $entry,
        ], 201);
    }


    /**
     * Egy entry lekérése
     * GET /api/entries/{id}
     */
    public function show(Request $request, $id)
    {
        // Entry lekérése user_id alapján (biztonsági ellenőrzés)
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

    /**
     * Entry módosítása
     * PUT/PATCH /api/entries/{id}
     */
    public function update(Request $request, $id)
    {
        // Entry lekérése user_id alapján
        $entry = Entry::where('entry_id', $id)
            ->where('user_id', $request->user()->user_id)
            ->where('is_deleted', false)
            ->first();

        if (!$entry) {
            return response()->json([
                'message' => 'Entry nem található',
            ], 404);
        }

        // Validáció - PONTOS ENUM értékek
        $validated = $request->validate([
            'mood' => ['nullable', Rule::in(['Lehangolt', 'Kiegyensúlyozott', 'Vidám'])],
            'weather' => ['sometimes', Rule::in(['Napos', 'Felhős', 'Esős', 'Szeles', 'Havas'])],
            'sleep_quality' => ['sometimes', Rule::in(['Nagyon rossz', 'Rossz', 'Közepes', 'Jó', 'Kiváló'])],
            'activities' => ['sometimes', Rule::in(['Munka', 'Tanulás', 'Pihenés', 'Sport', 'Szórakozás', 'Egyéb'])],
            'health_action' => ['sometimes', Rule::in(['Mozgás', 'Egészséges étkezés', 'Pihenés', 'Semmi'])],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        // Ha mood változik, új quote generálás
        if (array_key_exists('mood', $validated)) {
            if ($validated['mood'] !== $entry->mood) {
                if ($validated['mood'] !== null) {
                    // Mood megadva → mood szerint
                    $quote = Quote::where('mood', $validated['mood'])
                        ->inRandomOrder()
                        ->first();
                } else {
                    // Mood NULL → random az egészből
                    $quote = Quote::inRandomOrder()->first();
                }
                
                $validated['quote_id'] = $quote ? $quote->quote_id : null;
            }
        }


        // Entry frissítése
        $entry->update($validated);

        // Entry újratöltése quote-tal
        $entry->load('quote');

        return response()->json([
            'message' => 'Entry sikeresen frissítve',
            'entry' => $entry,
        ], 200);
    }

    /**
     * Entry törlése (soft delete)
     * DELETE /api/entries/{id}
     */
    public function destroy(Request $request, $id)
    {
        // Entry lekérése user_id alapján
        $entry = Entry::where('entry_id', $id)
            ->where('user_id', $request->user()->user_id)
            ->where('is_deleted', false)
            ->first();

        if (!$entry) {
            return response()->json([
                'message' => 'Entry nem található',
            ], 404);
        }

        // Soft delete (is_deleted flag)
        $entry->update(['is_deleted' => true]);
        $entry->delete(); // Laravel soft delete (deleted_at)

        return response()->json([
            'message' => 'Entry sikeresen törölve',
        ], 200);
    }
}
