<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportArancelCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arancel:import {file : Ruta al archivo CSV con códigos verificados}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar códigos arancelarios verificados desde archivo CSV';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("Archivo no encontrado: {$filePath}");
            return 1;
        }

        $this->info("Importando códigos arancelarios desde: {$filePath}");
        $this->newLine();

        $file = fopen($filePath, 'r');
        
        // Leer headers
        $headers = fgetcsv($file);
        
        if (!$this->confirm('¿Desea continuar con la importación? Esto actualizará los códigos arancelarios en la base de datos.')) {
            $this->info('Importación cancelada.');
            return 0;
        }

        $updated = 0;
        $skipped = 0;
        $errors = [];

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 6) {
                continue;
            }

            $id = $row[0];
            $key = $row[1];
            $newCode = trim($row[5] ?? ''); // Código Verificado (8 dígitos)
            $newSubpartida = trim($row[6] ?? ''); // Subpartida Verificada (10 dígitos)

            // Solo actualizar si hay códigos verificados
            if (empty($newCode) && empty($newSubpartida)) {
                $skipped++;
                continue;
            }

            $product = Product::find($id);
            
            if (!$product) {
                $errors[] = "Producto ID {$id} ({$key}) no encontrado";
                continue;
            }

            $updateData = [];
            if (!empty($newCode)) {
                $updateData['arancel_code'] = $newCode;
            }
            if (!empty($newSubpartida)) {
                $updateData['arancel_subpartida'] = $newSubpartida;
            }

            if (!empty($updateData)) {
                $product->update($updateData);
                $updated++;
                $this->line("✓ Actualizado: {$product->name} ({$key})");
            }
        }

        fclose($file);

        $this->newLine();
        $this->info("=== Resumen de Importación ===");
        $this->info("✓ Productos actualizados: {$updated}");
        $this->info("⊘ Productos omitidos: {$skipped}");

        if (!empty($errors)) {
            $this->warn("⚠ Errores: " . count($errors));
            foreach ($errors as $error) {
                $this->error("  - {$error}");
            }
        }

        return 0;
    }
}
