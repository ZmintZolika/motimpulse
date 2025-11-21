<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotivationalQuote;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
        $quotes = [
            [
                'category' => 1,
                'text' => 'A siker nem a véletlen műve, hanem a kitartás eredménye.',
                'author' => 'Albert Schweitzer',
            ],
            [
                'category' => 2,
                'text' => 'Az élet nem arról szól, hogy várjuk, míg elmúlik a vihar, hanem megtanulunk táncolni az esőben.',
                'author' => 'Vivian Greene',
            ],
            [
                'category' => 1,
                'text' => 'A lehetetlen csak addig tűnik annak, amíg meg nem valósítod.',
                'author' => 'Nelson Mandela',
            ],
            [
                'category' => 3,
                'text' => 'Ne azzal foglalkozz, hogy jobb legyél másoknál, hanem azzal, hogy jobb legyél önmagad tegnapi változatánál.',
                'author' => 'Dalai Láma',
            ],
            [
                'category' => 2,
                'text' => 'A boldogság nem valami kész dolog. A tetteidből születik.',
                'author' => 'Dalai Láma',
            ],
            [
                'category' => 1,
                'text' => 'Ha le tudod festeni a jövődet, képes vagy megteremteni is.',
                'author' => 'Napoleon Hill',
            ],
            [
                'category' => 3,
                'text' => 'Az önfegyelem a híd a céljaid és az eredményeid között.',
                'author' => 'Jim Rohn',
            ],
            [
                'category' => 2,
                'text' => 'Az élet rövid. Mosolyogj, amíg még van fogad.',
                'author' => 'Ismeretlen',
            ],
            [
                'category' => 1,
                'text' => 'A siker titka az, hogy elkezded, mielőtt készen állnál.',
                'author' => 'Marie Forleo',
            ],
            [
                'category' => 3,
                'text' => 'Ne félj a lassú haladástól, csak az állva maradástól.',
                'author' => 'Kínai közmondás',
            ],
        ];

        foreach ($quotes as $quote) {
            MotivationalQuote::create($quote);
        }
    }
}

