<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            ['name' => 'Amazon', 'order' => 1, 'is_active' => true],
            ['name' => 'eBay', 'order' => 2, 'is_active' => true],
            ['name' => 'Walmart', 'order' => 3, 'is_active' => true],
            ['name' => 'Target', 'order' => 4, 'is_active' => true],
            ['name' => 'Best Buy', 'order' => 5, 'is_active' => true],
            ['name' => 'Macy\'s', 'order' => 6, 'is_active' => true],
            ['name' => 'Nike', 'order' => 7, 'is_active' => true],
            ['name' => 'Adidas', 'order' => 8, 'is_active' => true],
            ['name' => 'Apple', 'order' => 9, 'is_active' => true],
            ['name' => 'Microsoft', 'order' => 10, 'is_active' => true],
            ['name' => 'Home Depot', 'order' => 11, 'is_active' => true],
            ['name' => 'Costco', 'order' => 12, 'is_active' => true],
        ];

        foreach ($stores as $index => $store) {
            Store::updateOrCreate(
                ['name' => $store['name']],
                [
                    'name' => $store['name'],
                    'logo_url' => null,
                    'website_url' => null,
                    'order' => $store['order'],
                    'is_active' => $store['is_active'],
                ]
            );
        }
    }
}
