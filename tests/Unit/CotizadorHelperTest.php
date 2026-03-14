<?php

namespace Tests\Unit;

use App\Helpers\CotizadorHelper;
use Tests\TestCase;

class CotizadorHelperTest extends TestCase
{
    public function test_format_product_name_agrega_espacios(): void
    {
        $result = CotizadorHelper::formatProductName('Celulares_NuevosSolamente');
        $this->assertStringContainsString(' ', $result);
        $this->assertStringNotContainsString('_', $result);
    }

    public function test_format_product_name_reemplaza_codigos_especiales(): void
    {
        $result = CotizadorHelper::formatProductName('TelevisoresMayorA20EXSYMenorOIgualA32EXSPulgadas');
        $this->assertStringContainsString(' ', $result);
    }
}
