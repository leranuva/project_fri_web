<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class VerifyArancelCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arancel:verify 
                            {--product= : Verificar un producto específico por key}
                            {--missing : Mostrar productos sin código arancelario}
                            {--export : Exportar lista para verificación manual}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar y gestionar códigos arancelarios de productos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('missing')) {
            return $this->showMissingCodes();
        }

        if ($this->option('export')) {
            return $this->exportForVerification();
        }

        if ($productKey = $this->option('product')) {
            return $this->verifyProduct($productKey);
        }

        $this->info('=== Verificación de Códigos Arancelarios ===');
        $this->newLine();
        $this->info('Opciones disponibles:');
        $this->line('  --missing    : Mostrar productos sin código arancelario');
        $this->line('  --export     : Exportar lista para verificación manual');
        $this->line('  --product=KEY: Verificar un producto específico');
        $this->newLine();
        $this->info('Para verificar códigos, visite: https://www.aduana.gob.ec/arancel-nacional/');
    }

    /**
     * Mostrar productos sin código arancelario
     */
    private function showMissingCodes()
    {
        $products = Product::whereNull('arancel_code')
            ->orWhere('arancel_code', '')
            ->get();

        if ($products->isEmpty()) {
            $this->info('✓ Todos los productos tienen código arancelario asignado.');
            return 0;
        }

        $this->warn("⚠ Productos sin código arancelario: {$products->count()}");
        $this->newLine();

        $headers = ['ID', 'Key', 'Nombre'];
        $data = $products->map(function ($product) {
            return [
                $product->id,
                $product->key,
                $product->name,
            ];
        })->toArray();

        $this->table($headers, $data);
        return 0;
    }

    /**
     * Exportar lista para verificación manual
     */
    private function exportForVerification()
    {
        $products = Product::orderBy('name')->get();

        $filename = storage_path('app/arancel_verification_' . date('Y-m-d') . '.csv');
        $file = fopen($filename, 'w');

        // Headers CSV
        fputcsv($file, [
            'ID',
            'Key',
            'Nombre',
            'Código Actual (8 dígitos)',
            'Subpartida Actual (10 dígitos)',
            'Código Verificado (8 dígitos)',
            'Subpartida Verificada (10 dígitos)',
            'Fecha Verificación',
            'Observaciones'
        ]);

        foreach ($products as $product) {
            fputcsv($file, [
                $product->id,
                $product->key,
                $product->name,
                $product->arancel_code ?? '',
                $product->arancel_subpartida ?? '',
                '', // Para llenar después de verificar
                '', // Para llenar después de verificar
                '', // Fecha de verificación
                ''  // Observaciones
            ]);
        }

        fclose($file);

        $this->info("✓ Archivo exportado: {$filename}");
        $this->info("  Total productos: {$products->count()}");
        $this->newLine();
        $this->info('Pasos siguientes:');
        $this->line('1. Abra el archivo CSV en Excel o similar');
        $this->line('2. Verifique cada código en: https://www.aduana.gob.ec/arancel-nacional/');
        $this->line('3. Complete las columnas "Código Verificado" y "Subpartida Verificada"');
        $this->line('4. Use el comando: php artisan arancel:import para importar los códigos verificados');
        
        return 0;
    }

    /**
     * Verificar un producto específico
     */
    private function verifyProduct(string $key)
    {
        $product = Product::where('key', $key)->first();

        if (!$product) {
            $this->error("Producto no encontrado: {$key}");
            return 1;
        }

        $this->info("=== Información del Producto ===");
        $this->table(
            ['Campo', 'Valor'],
            [
                ['ID', $product->id],
                ['Key', $product->key],
                ['Nombre', $product->name],
                ['Código Actual (8 dígitos)', $product->arancel_code ?? 'NO ASIGNADO'],
                ['Subpartida Actual (10 dígitos)', $product->arancel_subpartida ?? 'NO ASIGNADO'],
                ['Ad-Valorem', ($product->ad_valorem * 100) . '%'],
                ['Arancel Específico', '$' . number_format($product->arancel_especifico, 2)],
            ]
        );

        $this->newLine();
        $this->info('Para verificar el código arancelario:');
        $this->line('1. Visite: https://www.aduana.gob.ec/arancel-nacional/');
        $this->line('2. Busque: ' . $product->name);
        $this->line('3. Verifique que el código coincida con la descripción');
        $this->line('4. Actualice usando: Product::where("key", "' . $key . '")->update(["arancel_code" => "XXXX.XX.XX", "arancel_subpartida" => "XXXX.XX.XX.XX"])');

        return 0;
    }
}




