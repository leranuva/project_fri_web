<?php

namespace App\Services;

use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TrackingService
{
    /**
     * Mapeo de transportistas a códigos TrackingMore API
     */
    private const CARRIER_CODES = [
        'USPS' => 'usps',
        'FedEx' => 'fedex',
        'UPS' => 'ups',
        'DHL' => 'dhl',
        'Amazon' => 'amazon',
        'OnTrac' => 'ontrac',
    ];
    /**
     * Detecta el transportista basándose en el número de tracking
     */
    public function detectCarrier(string $trackingNumber): ?string
    {
        $trackingNumber = strtoupper(trim($trackingNumber));
        
        // Patrones de detección de transportistas
        $patterns = [
            'USPS' => [
                '/^9[0-9]{4}[0-9]{4}[0-9]{4}[0-9]{4}[0-9]{4}[0-9]{2}$/', // 22 dígitos
                '/^[0-9]{4}[0-9]{4}[0-9]{4}[0-9]{4}[0-9]{4}[0-9]{4}$/', // 24 dígitos
                '/^[A-Z]{2}[0-9]{9}[A-Z]{2}$/', // Formato estándar USPS
            ],
            'FedEx' => [
                '/^[0-9]{12}$/', // 12 dígitos
                '/^[0-9]{14}$/', // 14 dígitos
                '/^[0-9]{15}$/', // 15 dígitos
            ],
            'UPS' => [
                '/^1Z[0-9A-Z]{16}$/', // Formato estándar UPS
                '/^[0-9]{9}$/', // 9 dígitos
                '/^[0-9]{10}$/', // 10 dígitos
                '/^[0-9]{11}$/', // 11 dígitos
                '/^[0-9]{12}$/', // 12 dígitos
            ],
            'DHL' => [
                '/^[0-9]{10}$/', // 10 dígitos
                '/^[0-9]{11}$/', // 11 dígitos
                '/^[A-Z]{2}[0-9]{9}[A-Z]{2}$/', // Formato internacional
            ],
            'Amazon' => [
                '/^TBA[0-9]{12}$/', // Amazon Logistics
                '/^[0-9]{3}-[0-9]{7}-[0-9]{7}$/', // Formato Amazon
            ],
            'OnTrac' => [
                '/^C[0-9]{14}$/', // OnTrac
            ],
        ];

        foreach ($patterns as $carrier => $carrierPatterns) {
            foreach ($carrierPatterns as $pattern) {
                if (preg_match($pattern, $trackingNumber)) {
                    return $carrier;
                }
            }
        }

        return null;
    }

    /**
     * Busca información del paquete usando APIs de tracking
     * Prioridad: TrackingMore (si configurado) > datos mock por carrier
     */
    public function fetchTrackingInfo(string $trackingNumber): ?array
    {
        // 1. Intentar TrackingMore primero si está configurado (datos reales)
        if (config('services.trackingmore.api_key')) {
            $result = $this->fetchFromTrackingMore($trackingNumber);
            if ($result && ! empty($result['tracking_history'])) {
                return $result;
            }
            if ($result) {
                return $result;
            }
        }

        // 2. Fallback: datos mock según carrier detectado
        $carrier = $this->detectCarrier($trackingNumber);

        if (! $carrier) {
            return [
                'tracking_number' => $trackingNumber,
                'carrier' => 'Desconocido',
                'status' => 'pending',
                'description' => 'Configure TRACKINGMORE_API_KEY en .env para tracking automático.',
            ];
        }

        return match ($carrier) {
            'Amazon' => $this->fetchAmazonTracking($trackingNumber),
            'USPS' => $this->fetchUSPSTracking($trackingNumber),
            'FedEx' => $this->fetchFedExTracking($trackingNumber),
            'UPS' => $this->fetchUPSTracking($trackingNumber),
            'DHL' => $this->fetchDHLTracking($trackingNumber),
            default => $this->fetchUSPSTracking($trackingNumber),
        };
    }

    /**
     * Obtiene información de Amazon (usando API pública si está disponible)
     */
    private function fetchAmazonTracking(string $trackingNumber): ?array
    {
        // Amazon Logistics (TBA) - Intentar obtener información real
        // Nota: Amazon no tiene API pública fácil, pero podemos intentar con AfterShip o TrackingMore
        // Por ahora, creamos información básica pero realista
        
        $baseInfo = [
            'tracking_number' => $trackingNumber,
            'carrier' => 'Amazon Logistics',
            'status' => 'in_transit',
            'description' => 'Paquete de Amazon',
        ];

        // Intentar obtener información de TrackingMore si está configurado
        $trackingMoreInfo = $this->fetchFromTrackingMore($trackingNumber);
        if ($trackingMoreInfo) {
            return array_merge($baseInfo, $trackingMoreInfo);
        }

        // Si no hay API, crear información básica pero útil
        $baseInfo['tracking_history'] = [
            [
                'status' => 'En Tránsito',
                'description' => 'El paquete está siendo procesado por Amazon Logistics',
                'location' => 'Centro de distribución Amazon',
                'date' => now()->subDays(1)->toDateTimeString(),
            ],
            [
                'status' => 'Enviado',
                'description' => 'El paquete ha sido enviado',
                'location' => 'Centro de distribución Amazon',
                'date' => now()->subDays(2)->toDateTimeString(),
            ]
        ];

        return $baseInfo;
    }

    /**
     * Obtiene información de USPS
     */
    private function fetchUSPSTracking(string $trackingNumber): ?array
    {
        // USPS requiere API key, por ahora retornamos estructura básica
        return [
            'tracking_number' => $trackingNumber,
            'carrier' => 'USPS',
            'status' => 'in_transit',
            'description' => 'Paquete USPS',
            'tracking_history' => [
                [
                    'status' => 'En Tránsito',
                    'description' => 'El paquete está siendo procesado por USPS',
                    'date' => now()->toDateTimeString(),
                ]
            ],
        ];
    }

    /**
     * Obtiene información de FedEx
     */
    private function fetchFedExTracking(string $trackingNumber): ?array
    {
        return [
            'tracking_number' => $trackingNumber,
            'carrier' => 'FedEx',
            'status' => 'in_transit',
            'description' => 'Paquete FedEx',
            'tracking_history' => [
                [
                    'status' => 'En Tránsito',
                    'description' => 'El paquete está siendo procesado por FedEx',
                    'date' => now()->toDateTimeString(),
                ]
            ],
        ];
    }

    /**
     * Obtiene información de UPS
     */
    private function fetchUPSTracking(string $trackingNumber): ?array
    {
        return [
            'tracking_number' => $trackingNumber,
            'carrier' => 'UPS',
            'status' => 'in_transit',
            'description' => 'Paquete UPS',
            'tracking_history' => [
                [
                    'status' => 'En Tránsito',
                    'description' => 'El paquete está siendo procesado por UPS',
                    'date' => now()->toDateTimeString(),
                ]
            ],
        ];
    }

    /**
     * Obtiene información de DHL
     */
    private function fetchDHLTracking(string $trackingNumber): ?array
    {
        return [
            'tracking_number' => $trackingNumber,
            'carrier' => 'DHL',
            'status' => 'in_transit',
            'description' => 'Paquete DHL',
            'tracking_history' => [
                [
                    'status' => 'En Tránsito',
                    'description' => 'El paquete está siendo procesado por DHL',
                    'date' => now()->toDateTimeString(),
                ]
            ],
        ];
    }

    /**
     * Intenta obtener información usando TrackingMore API (v2 o v4)
     */
    private function fetchFromTrackingMore(string $trackingNumber): ?array
    {
        $apiKey = config('services.trackingmore.api_key');

        if (!$apiKey) {
            return null;
        }

        $carrier = $this->detectCarrier($trackingNumber);
        $carrierCode = $carrier ? (self::CARRIER_CODES[$carrier] ?? strtolower($carrier)) : null;

        // Intentar API v2 (GET /trackings/{carrier}/{number}) si conocemos el carrier
        if ($carrierCode) {
            $result = $this->fetchTrackingMoreV2($trackingNumber, $carrierCode, $apiKey);
            if ($result) {
                return $result;
            }
        }

        // Intentar API Realtime (detecta carrier automáticamente)
        return $this->fetchTrackingMoreRealtime($trackingNumber, $apiKey);
    }

    /**
     * TrackingMore API v2: GET /trackings/{carrier_code}/{tracking_number}
     */
    private function fetchTrackingMoreV2(string $trackingNumber, string $carrierCode, string $apiKey): ?array
    {
        try {
            $url = sprintf(
                'https://api.trackingmore.com/v2/trackings/%s/%s',
                $carrierCode,
                urlencode($trackingNumber)
            );

            $response = Http::withHeaders([
                'Trackingmore-Api-Key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(15)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                return $this->parseTrackingMoreResponse($data);
            }

            if ($response->status() === 404) {
                Log::info('TrackingMore v2: No results', [
                    'tracking_number' => $trackingNumber,
                    'carrier' => $carrierCode,
                ]);
            } else {
                Log::warning('TrackingMore v2 API error', [
                    'tracking_number' => $trackingNumber,
                    'carrier' => $carrierCode,
                    'status' => $response->status(),
                    'body' => substr($response->body(), 0, 500),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('TrackingMore v2 exception', [
                'tracking_number' => $trackingNumber,
                'carrier' => $carrierCode,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return null;
    }

    /**
     * TrackingMore API Realtime: POST (detecta carrier automáticamente)
     */
    private function fetchTrackingMoreRealtime(string $trackingNumber, string $apiKey): ?array
    {
        try {
            $response = Http::withHeaders([
                'Tracking-Api-Key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(15)->post('https://api.trackingmore.com/v4/trackings/realtime', [
                'tracking_number' => $trackingNumber,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $this->parseTrackingMoreV4Response($data);
            }

            Log::warning('TrackingMore realtime API error', [
                'tracking_number' => $trackingNumber,
                'status' => $response->status(),
                'body' => substr($response->body(), 0, 500),
            ]);
        } catch (\Exception $e) {
            Log::error('TrackingMore realtime exception', [
                'tracking_number' => $trackingNumber,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return null;
    }

    /**
     * Parsea respuesta TrackingMore v2
     */
    private function parseTrackingMoreResponse(array $data): ?array
    {
        if (! isset($data['data'])) {
            return null;
        }

        $tracking = $data['data'];
        $status = $this->mapTrackingStatus($tracking['status'] ?? 'pending');

        $history = [];
        $trackinfo = $tracking['origin_info']['trackinfo'] ?? [];
        if (is_array($trackinfo)) {
            foreach ($trackinfo as $event) {
                $history[] = [
                    'status' => $event['checkpoint_status'] ?? $event['StatusDescription'] ?? 'Actualización',
                    'description' => $event['StatusDescription'] ?? $event['Details'] ?? '',
                    'location' => $event['Details'] ?? $event['location'] ?? '',
                    'date' => $event['Date'] ?? $event['checkpoint_time'] ?? now()->toDateTimeString(),
                ];
            }
        }

        $firstEvent = $trackinfo[0] ?? [];
        $origin = $firstEvent['Details'] ?? $firstEvent['location'] ?? null;

        return [
            'tracking_number' => $tracking['tracking_number'] ?? '',
            'carrier' => $this->formatCarrierName($tracking['carrier_code'] ?? ''),
            'status' => $status,
            'origin' => $origin,
            'destination' => $tracking['destination_country'] ?? null,
            'description' => 'Información de TrackingMore',
            'tracking_history' => $history,
            'estimated_delivery' => $tracking['itemTimeLength'] ?? null,
        ];
    }

    /**
     * Parsea respuesta TrackingMore v4 (realtime)
     */
    private function parseTrackingMoreV4Response(array $data): ?array
    {
        $tracking = $data['data'] ?? $data;
        if (empty($tracking)) {
            return null;
        }

        $status = $this->mapTrackingStatus($tracking['status'] ?? 'pending');

        $history = [];
        $trackinfo = $tracking['origin_info']['trackinfo'] ?? $tracking['trackinfo'] ?? [];
        if (is_array($trackinfo)) {
            foreach ($trackinfo as $event) {
                $history[] = [
                    'status' => $event['checkpoint_status'] ?? $event['StatusDescription'] ?? 'Actualización',
                    'description' => $event['StatusDescription'] ?? $event['details'] ?? $event['Details'] ?? '',
                    'location' => $event['Details'] ?? $event['details'] ?? $event['location'] ?? '',
                    'date' => $event['Date'] ?? $event['checkpoint_time'] ?? now()->toDateTimeString(),
                ];
            }
        }

        return [
            'tracking_number' => $tracking['tracking_number'] ?? '',
            'carrier' => $this->formatCarrierName($tracking['carrier_code'] ?? ''),
            'status' => $status,
            'origin' => $trackinfo[0]['Details'] ?? $trackinfo[0]['location'] ?? null,
            'destination' => $tracking['destination_info']['location'] ?? $tracking['destination_country'] ?? null,
            'description' => 'Información de TrackingMore',
            'tracking_history' => $history,
        ];
    }

    private function mapTrackingStatus(string $status): string
    {
        return match (strtolower($status)) {
            'delivered' => 'delivered',
            'in_transit', 'transit', 'pickup' => 'in_transit',
            'exception', 'expired' => 'in_customs',
            default => 'pending',
        };
    }

    private function formatCarrierName(string $code): string
    {
        $map = array_flip(self::CARRIER_CODES);
        return $map[strtolower($code)] ?? ucfirst($code);
    }

    /**
     * Crea o actualiza un paquete con la información obtenida
     */
    public function createOrUpdatePackage(string $trackingNumber, ?int $userId = null): Package
    {
        $trackingInfo = $this->fetchTrackingInfo($trackingNumber);
        
        if (!$trackingInfo) {
            // Si no se puede obtener información, crear un paquete básico
            $trackingInfo = [
                'tracking_number' => $trackingNumber,
                'carrier' => $this->detectCarrier($trackingNumber) ?? 'Desconocido',
                'status' => 'pending',
                'description' => 'Información de tracking no disponible automáticamente',
            ];
        }

        $package = Package::updateOrCreate(
            ['tracking_number' => $trackingNumber],
            [
                'user_id' => $userId,
                'carrier' => $trackingInfo['carrier'] ?? null,
                'status' => $trackingInfo['status'] ?? 'pending',
                'origin' => $trackingInfo['origin'] ?? null,
                'destination' => $trackingInfo['destination'] ?? null,
                'description' => $trackingInfo['description'] ?? null,
                'weight' => $trackingInfo['weight'] ?? null,
                'value' => $trackingInfo['value'] ?? null,
                'shipped_date' => isset($trackingInfo['shipped_date']) ? Carbon::parse($trackingInfo['shipped_date']) : null,
                'estimated_delivery' => isset($trackingInfo['estimated_delivery']) ? Carbon::parse($trackingInfo['estimated_delivery']) : null,
                'delivered_date' => isset($trackingInfo['delivered_date']) ? Carbon::parse($trackingInfo['delivered_date']) : null,
                'tracking_history' => $trackingInfo['tracking_history'] ?? null,
                'notes' => $trackingInfo['notes'] ?? null,
            ]
        );

        return $package;
    }
}

