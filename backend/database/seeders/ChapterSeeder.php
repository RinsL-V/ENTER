<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChapterSeeder extends Seeder
{
    public function run()
    {
        DB::table('chapters')->insert([
            [
                'title' => 'Глава 1: Архетипы и тайны их влияния',
                'description' => 'Глубокое погружение в мир архетипов и их влияние на подсознательное восприятие. Изучение как использовать архетипы для создания харизмы и притягательности.',
                'image_url' => '/public/card-girl.png',
                'price' => 999.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Глава 2: Магнетизм голоса и речи',
                'description' => 'Искусство владения голосом и речью. Техники развития тембра, интонации и убедительности. Секреты как сделать свою речь завораживающей.',
                'image_url' => '/public/card-girl2.png',
                'price' => 1299.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Глава 3: Тайны одежды, макияжа и ароматов',
                'description' => 'Создание гармоничного образа через одежду, макияж и парфюмерию. Как подчеркнуть индивидуальность и создавать нужное впечатление.',
                'image_url' => '/public/card-girl3.png',
                'price' => 1499.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
