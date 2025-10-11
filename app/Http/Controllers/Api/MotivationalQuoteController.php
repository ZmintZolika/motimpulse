<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MotivationalQuote;
use Illuminate\Http\Request;

class MotivationalQuoteController extends Controller
{
    public function index()
    {
        $quotes = MotivationalQuote::all();
        return response()->json($quotes);
    }

    public function random(Request $request)
    {
        $category = $request->query('category');

        $query = MotivationalQuote::query();

        if ($category) {
            $query->where('category', $category);
        }

        $quote = $query->inRandomOrder()->first();

        return response()->json($quote);
    }
}
