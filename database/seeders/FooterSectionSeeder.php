<?php

namespace Database\Seeders;

use App\Models\FooterSection;
use Illuminate\Database\Seeder;

class FooterSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FooterSection::updateOrCreate(
            ['id' => 1],
            [
                'brand_name' => 'Flat Rate Imports',
                'copyright_text' => '© ' . date('Y') . ' Flat Rate Imports. All rights reserved. Built with modern CSS and love.',
                'is_active' => true,
            ]
        );
    }
}
