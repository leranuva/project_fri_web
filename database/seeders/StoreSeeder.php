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
            [
                'name' => 'Amazon',
                'order' => 1,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.amazon.com'
            ],
            [
                'name' => 'eBay',
                'order' => 2,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.ebay.com'
            ],
            [
                'name' => 'Walmart',
                'order' => 3,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.walmart.com'
            ],
            [
                'name' => 'Target',
                'order' => 4,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.target.com'
            ],
            [
                'name' => 'Best Buy',
                'order' => 5,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.bestbuy.com'
            ],
            [
                'name' => 'Macy\'s',
                'order' => 6,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.macys.com'
            ],
            [
                'name' => 'Nike',
                'order' => 7,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.nike.com'
            ],
            [
                'name' => 'Adidas',
                'order' => 8,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.adidas.com'
            ],
            [
                'name' => 'Apple',
                'order' => 9,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.apple.com'
            ],
            [
                'name' => 'Microsoft',
                'order' => 10,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.microsoft.com'
            ],
            [
                'name' => 'Home Depot',
                'order' => 11,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.homedepot.com'
            ],
            [
                'name' => 'Costco',
                'order' => 12,
                'is_active' => true,
                'logo_url' => null,
                'website_url' => 'https://www.costco.com'
            ],
        ];

        foreach ($stores as $store) {
            Store::updateOrCreate(
                ['name' => $store['name']],
                [
                    'name' => $store['name'],
                    'logo_url' => $store['logo_url'] ?? null,
                    'website_url' => $store['website_url'] ?? null,
                    'order' => $store['order'],
                    'is_active' => $store['is_active'],
                ]
            );
        }
    }
}
