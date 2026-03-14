<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'tracking_number' => 'US123456789',
                'carrier' => 'USPS',
                'status' => 'in_transit',
                'origin' => 'New York, NY, USA',
                'destination' => 'Miami, FL, USA',
                'description' => 'Paquete con productos electrónicos',
                'weight' => 5.50,
                'value' => 250.00,
                'shipped_date' => Carbon::now()->subDays(3),
                'estimated_delivery' => Carbon::now()->addDays(5),
                'tracking_history' => [
                    [
                        'status' => 'Enviado',
                        'description' => 'El paquete ha sido enviado desde el origen',
                        'location' => 'New York, NY, USA',
                        'date' => Carbon::now()->subDays(3)->toDateTimeString(),
                    ],
                    [
                        'status' => 'En Tránsito',
                        'description' => 'El paquete está en camino al centro de distribución',
                        'location' => 'Philadelphia, PA, USA',
                        'date' => Carbon::now()->subDays(2)->toDateTimeString(),
                    ],
                    [
                        'status' => 'En Tránsito',
                        'description' => 'El paquete ha llegado al centro de distribución',
                        'location' => 'Atlanta, GA, USA',
                        'date' => Carbon::now()->subDays(1)->toDateTimeString(),
                    ],
                ],
                'notes' => 'Paquete con seguro incluido',
            ],
            [
                'tracking_number' => 'FEDEX987654321',
                'carrier' => 'FedEx',
                'status' => 'received',
                'origin' => 'Los Angeles, CA, USA',
                'destination' => 'Miami, FL, USA',
                'description' => 'Ropa y accesorios',
                'weight' => 2.30,
                'value' => 150.00,
                'shipped_date' => Carbon::now()->subDays(5),
                'estimated_delivery' => Carbon::now()->addDays(2),
                'tracking_history' => [
                    [
                        'status' => 'Enviado',
                        'description' => 'El paquete ha sido enviado',
                        'location' => 'Los Angeles, CA, USA',
                        'date' => Carbon::now()->subDays(5)->toDateTimeString(),
                    ],
                    [
                        'status' => 'En Tránsito',
                        'description' => 'En camino al destino',
                        'location' => 'Phoenix, AZ, USA',
                        'date' => Carbon::now()->subDays(4)->toDateTimeString(),
                    ],
                    [
                        'status' => 'Recibido',
                        'description' => 'El paquete ha sido recibido en el casillero',
                        'location' => 'Miami, FL, USA',
                        'date' => Carbon::now()->subDays(1)->toDateTimeString(),
                    ],
                ],
                'notes' => 'Listo para procesamiento de importación',
            ],
            [
                'tracking_number' => 'UPS456789123',
                'carrier' => 'UPS',
                'status' => 'delivered',
                'origin' => 'Chicago, IL, USA',
                'destination' => 'Miami, FL, USA',
                'description' => 'Productos de belleza',
                'weight' => 1.80,
                'value' => 85.00,
                'shipped_date' => Carbon::now()->subDays(10),
                'estimated_delivery' => Carbon::now()->subDays(3),
                'delivered_date' => Carbon::now()->subDays(2),
                'tracking_history' => [
                    [
                        'status' => 'Enviado',
                        'description' => 'El paquete ha sido enviado',
                        'location' => 'Chicago, IL, USA',
                        'date' => Carbon::now()->subDays(10)->toDateTimeString(),
                    ],
                    [
                        'status' => 'En Tránsito',
                        'description' => 'En camino',
                        'location' => 'Louisville, KY, USA',
                        'date' => Carbon::now()->subDays(8)->toDateTimeString(),
                    ],
                    [
                        'status' => 'En Aduana',
                        'description' => 'El paquete está siendo procesado en aduana',
                        'location' => 'Miami, FL, USA',
                        'date' => Carbon::now()->subDays(5)->toDateTimeString(),
                    ],
                    [
                        'status' => 'Entregado',
                        'description' => 'El paquete ha sido entregado exitosamente',
                        'location' => 'Miami, FL, USA',
                        'date' => Carbon::now()->subDays(2)->toDateTimeString(),
                    ],
                ],
                'notes' => 'Entrega completada',
            ],
            [
                'tracking_number' => 'DHL789123456',
                'carrier' => 'DHL',
                'status' => 'in_customs',
                'origin' => 'Seattle, WA, USA',
                'destination' => 'Miami, FL, USA',
                'description' => 'Electrodomésticos',
                'weight' => 12.50,
                'value' => 450.00,
                'shipped_date' => Carbon::now()->subDays(7),
                'estimated_delivery' => Carbon::now()->addDays(3),
                'tracking_history' => [
                    [
                        'status' => 'Enviado',
                        'description' => 'El paquete ha sido enviado',
                        'location' => 'Seattle, WA, USA',
                        'date' => Carbon::now()->subDays(7)->toDateTimeString(),
                    ],
                    [
                        'status' => 'En Tránsito',
                        'description' => 'En camino al destino',
                        'location' => 'Denver, CO, USA',
                        'date' => Carbon::now()->subDays(5)->toDateTimeString(),
                    ],
                    [
                        'status' => 'En Aduana',
                        'description' => 'El paquete está siendo revisado en aduana',
                        'location' => 'Miami, FL, USA',
                        'date' => Carbon::now()->subDays(2)->toDateTimeString(),
                    ],
                ],
                'notes' => 'Requiere documentación adicional para aduana',
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
