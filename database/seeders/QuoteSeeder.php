<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quote;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
       $quotes = [
    // Lehangolt (rossz-közepes hangulat)
    ['quote_category' => 'Lehangolt', 'quote_text' => 'Minden nehézség magában hordozza a lehetőséget.', 'author' => 'Albert Einstein'],
    ['quote_category' => 'Lehangolt', 'quote_text' => 'A siker nem végleges, a kudarc nem végzetes: ami számít, az a folytatás bátorsága.', 'author' => 'Winston Churchill'],
    ['quote_category' => 'Lehangolt', 'quote_text' => 'A holnap reménye ad erőt a ma nehézségeinek leküzdéséhez.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Lehangolt', 'quote_text' => 'Kis lépések is előrehaladást jelentenek.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Lehangolt', 'quote_text' => 'A változás nem holnap kezdődik, hanem ma.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Lehangolt', 'quote_text' => 'Az út ezer mérföldre is egyetlen lépéssel kezdődik.', 'author' => 'Lao Ce'],
    ['quote_category' => 'Lehangolt', 'quote_text' => 'A világ mindig változik, és ha az ember fenn akar maradni, akkor bele kell menni a táncba', 'author' => 'Terry Pratchett'],
    

    // Kiegyensúlyozott (semleges hangulat)
    ['quote_category' => 'Kiegyensúlyozott', 'quote_text' => 'Minden nap új lehetőség a jobbá válásra.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Kiegyensúlyozott', 'quote_text' => 'A kitartás kulcs a sikerhez.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Kiegyensúlyozott', 'quote_text' => 'Légy könyörületes magaddal, ahogy másokkal is az vagy.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Kiegyensúlyozott', 'quote_text' => 'A nyugalom erő.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Kiegyensúlyozott', 'quote_text' => 'Ma jó nap arra, hogy jó napod legyen.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Kiegyensúlyozott', 'quote_text' => 'Figyelj a jelenre, ne a múltra vagy jövőre.', 'author' => 'Eckhart Tolle'],
    ['quote_category' => 'Kiegyensúlyozott', 'quote_text' => 'Eredmény kell, nem kifogás!', 'author' => 'Szerencsés Viktor'],

    // Vidám (jó-kiváló hangulat)
    ['quote_category' => 'Vidám', 'quote_text' => 'A boldogság belülről fakad.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Vidám', 'quote_text' => 'Élvezd a pillanatot!', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Vidám', 'quote_text' => 'A pozitív gondolatok pozitív eredményekhez vezetnek.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Vidám', 'quote_text' => 'Mosolyogj, mert mosolygásra érdemes!', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Vidám', 'quote_text' => 'Az élet csodálatos, ha hagyod, hogy az legyen!', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Vidám', 'quote_text' => 'Légy hálás a mai napért.', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Vidám', 'quote_text' => 'Ragyogj, és világítsd meg mások útját is!', 'author' => 'Ismeretlen'],
    ['quote_category' => 'Vidám', 'quote_text' => 'A boldogság fertőző - oszd meg!', 'author' => 'Ismeretlen'],
];

        foreach ($quotes as $quote) {
            Quote::create($quote);
        }
    }
}
