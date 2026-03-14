<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreLogosSeeder extends Seeder
{
    /**
     * Logos reales de las tiendas - CompanyEnrich Logo API.
     * https://companyenrich.com/logo-api
     * Sin API key, PNG transparente, 500K req/mes gratis.
     */
    public function run(): void
    {
        $stores = [
            ['name' => 'Amazon', 'logo_image' => 'https://api.companyenrich.com/logo/amazon.com', 'website_url' => 'https://www.amazon.com'],
            ['name' => 'eBay', 'logo_image' => 'https://api.companyenrich.com/logo/ebay.com', 'website_url' => 'https://www.ebay.com'],
            ['name' => 'Walmart', 'logo_image' => 'https://api.companyenrich.com/logo/walmart.com', 'website_url' => 'https://www.walmart.com'],
            ['name' => 'Target', 'logo_image' => 'https://api.companyenrich.com/logo/target.com', 'website_url' => 'https://www.target.com'],
            ['name' => 'Best Buy', 'logo_image' => 'https://api.companyenrich.com/logo/bestbuy.com', 'website_url' => 'https://www.bestbuy.com'],
            ['name' => 'Macy\'s', 'logo_image' => 'https://api.companyenrich.com/logo/macys.com', 'website_url' => 'https://www.macys.com'],
            ['name' => 'Nike', 'logo_image' => 'https://api.companyenrich.com/logo/nike.com', 'website_url' => 'https://www.nike.com'],
            ['name' => 'Adidas', 'logo_image' => 'https://api.companyenrich.com/logo/adidas.com', 'website_url' => 'https://www.adidas.com'],
            ['name' => 'Apple', 'logo_image' => 'https://api.companyenrich.com/logo/apple.com', 'website_url' => 'https://www.apple.com'],
            ['name' => 'Microsoft', 'logo_image' => 'https://api.companyenrich.com/logo/microsoft.com', 'website_url' => 'https://www.microsoft.com'],
            ['name' => 'Home Depot', 'logo_image' => 'https://api.companyenrich.com/logo/homedepot.com', 'website_url' => 'https://www.homedepot.com'],
            ['name' => 'Costco', 'logo_image' => 'https://api.companyenrich.com/logo/costco.com', 'website_url' => 'https://www.costco.com'],
        ];

        foreach ($stores as $index => $data) {
            Store::updateOrCreate(
                ['name' => $data['name']],
                [
                    'logo_image' => $data['logo_image'],
                    'website_url' => $data['website_url'] ?? null,
                    'order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('✓ Logos de ' . count($stores) . ' tiendas actualizados.');
    }
}
