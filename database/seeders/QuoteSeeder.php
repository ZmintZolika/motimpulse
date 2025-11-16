<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotivationalQuote;

class MotivationalQuoteSeeder extends Seeder
{
    public function run(): void
    {
        $quotes = [
            // Kategória 1-2: Rossz hangulat
            ['category' => 1, 'text' => 'Minden nehézség magában hordozza a lehetőséget.', 'author' => 'Albert Einstein'],
            ['category' => 1, 'text' => 'A siker nem végleges, a kudarc nem végzetes: ami számít, az a folytatás bátorsága.', 'author' => 'Winston Churchill'],
            ['category' => 2, 'text' => 'A holnap reménye ad erőt a ma nehézségeinek leküzdéséhez.', 'author' => 'Unknown'],
            ['category' => 2, 'text' => 'Kis lépések is előrehaladást jelentenek.', 'author' => 'Unknown'],

            // Kategória 3-4: Közepes-alacsony hangulat
            ['category' => 3, 'text' => 'A változás nem holnap kezdődik, hanem ma.', 'author' => 'Unknown'],
            ['category' => 3, 'text' => 'Minden nap új lehetőség a jobbá válásra.', 'author' => 'Unknown'],
            ['category' => 4, 'text' => 'Az út ezer mérföldre is egyetlen lépéssel kezdődik.', 'author' => 'Lao Ce'],
            ['category' => 4, 'text' => 'A kitartás kulcs a sikerhez.', 'author' => 'Unknown'],

            // Kategória 5-6: Semleges hangulat
            ['category' => 5, 'text' => 'Légy könyörületes magaddal, ahogy másokkal is az vagy.', 'author' => 'Unknown'],
            ['category' => 5, 'text' => 'A nyugalom erő.', 'author' => 'Unknown'],
            ['category' => 6, 'text' => 'Ma jó nap arra, hogy jó napod legyen.', 'author' => 'Unknown'],
            ['category' => 6, 'text' => 'Figyelj a jelenre, ne a múltra vagy jövőre.', 'author' => 'Eckhart Tolle'],

            // Kategória 7-8: Jó hangulat
            ['category' => 7, 'text' => 'A boldogság belülről fakad.', 'author' => 'Unknown'],
            ['category' => 7, 'text' => 'Élvezd a pillanatot!', 'author' => 'Unknown'],
            ['category' => 8, 'text' => 'A pozitív gondolatok pozitív eredményekhez vezetnek.', 'author' => 'Unknown'],
            ['category' => 8, 'text' => 'Mosolyogj, mert mosolygásra érdemes!', 'author' => 'Unknown'],

            // Kategória 9-10: Kiváló hangulat
            ['category' => 9, 'text' => 'Az élet csodálatos, ha hagyod, hogy az legyen!', 'author' => 'Unknown'],
            ['category' => 9, 'text' => 'Légy hálás a mai napért.', 'author' => 'Unknown'],
            ['category' => 10, 'text' => 'Ragyogj, és világítsd meg mások útját is!', 'author' => 'Unknown'],
            ['category' => 10, 'text' => 'A boldogság fertőző - oszd meg!', 'author' => 'Unknown'],
        ];

        foreach ($quotes as $quote) {
            MotivationalQuote::create($quote);
        }
    }
}
