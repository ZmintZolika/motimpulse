<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Összes quote lekérése
     * GET /api/quotes
     */
    public function index()
    {
        $quotes = Quote::orderBy('quote_id', 'asc')->get();

        return response()->json([
            'quotes' => $quotes,
        ], 200);
    }

    /**
     * Random quote lekérése (opcionális mood szűrő)
     * GET /api/quotes/random
     * GET /api/quotes/random?mood=Vidám
     */
    public function random(Request $request)
    {
        $mood = $request->query('mood');

        if ($mood) {
            // Validáció: mood értéke helyes-e?
            $validMoods = ['Lehangolt', 'Kiegyensúlyozott', 'Vidám'];
            
            if (!in_array($mood, $validMoods)) {
                return response()->json([
                    'message' => 'Érvénytelen mood érték. Elfogadott értékek: Lehangolt, Kiegyensúlyozott, Vidám',
                ], 400);
            }

            // Random quote mood szerint
            $quote = Quote::where('mood', $mood)
                ->inRandomOrder()
                ->first();
        } else {
            // Random quote az egész táblából
            $quote = Quote::inRandomOrder()->first();
        }

        if (!$quote) {
            return response()->json([
                'message' => 'Nincs elérhető quote',
            ], 404);
        }

        return response()->json([
            'quote' => $quote,
        ], 200);
    }
}
