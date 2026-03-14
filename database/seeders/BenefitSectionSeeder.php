<?php

namespace Database\Seeders;

use App\Models\BenefitSection;
use Illuminate\Database\Seeder;

class BenefitSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BenefitSection::updateOrCreate(
            ['id' => 1],
            [
                'title' => '¿Por qué elegir Flat Rate Imports?',
                'title_color' => '#ffffff',
                'is_active' => true,
            ]
        );
    }
}
