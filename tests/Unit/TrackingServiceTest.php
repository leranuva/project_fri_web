<?php

namespace Tests\Unit;

use App\Services\TrackingService;
use Tests\TestCase;

class TrackingServiceTest extends TestCase
{
    private TrackingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TrackingService;
    }

    public function test_detecta_usps_por_formato_22_digitos(): void
    {
        $carrier = $this->service->detectCarrier('940011189922334455667701');
        $this->assertSame('USPS', $carrier);
    }

    public function test_detecta_ups_por_formato_1z(): void
    {
        $carrier = $this->service->detectCarrier('1Z999AA10123456784');
        $this->assertSame('UPS', $carrier);
    }

    public function test_detecta_fedex_por_12_digitos(): void
    {
        $carrier = $this->service->detectCarrier('123456789012');
        $this->assertSame('FedEx', $carrier);
    }

    public function test_detecta_amazon_tba(): void
    {
        $carrier = $this->service->detectCarrier('TBA123456789012');
        $this->assertSame('Amazon', $carrier);
    }

    public function test_retorna_null_para_numero_desconocido(): void
    {
        $carrier = $this->service->detectCarrier('ABC123XYZ');
        $this->assertNull($carrier);
    }

    public function test_fetch_tracking_sin_api_retorna_estructura_mock(): void
    {
        config(['services.trackingmore.api_key' => null]);

        $result = $this->service->fetchTrackingInfo('1Z999AA10123456784');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('tracking_number', $result);
        $this->assertArrayHasKey('carrier', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertSame('1Z999AA10123456784', $result['tracking_number']);
        $this->assertSame('UPS', $result['carrier']);
    }

    public function test_fetch_tracking_numero_desconocido_retorna_pending(): void
    {
        config(['services.trackingmore.api_key' => null]);

        $result = $this->service->fetchTrackingInfo('UNKNOWN123');

        $this->assertIsArray($result);
        $this->assertSame('Desconocido', $result['carrier']);
        $this->assertSame('pending', $result['status']);
    }
}
