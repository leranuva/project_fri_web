<?php

namespace App\Listeners;

use App\Events\LeadCreated;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendLeadToWebhook
{
    public function handle(LeadCreated $event): void
    {
        $url = config('seo.webhook_leads_url');
        if (empty($url)) {
            return;
        }

        try {
            $lead = $event->lead;
            $payload = [
                'event' => 'lead.created',
                'timestamp' => now()->toIso8601String(),
                'data' => [
                    'id' => $lead->id,
                    'email' => $lead->email,
                    'producto' => $lead->producto,
                    'valor' => (float) $lead->valor,
                    'pais' => $lead->pais,
                    'score' => $lead->score,
                    'quote_count' => $lead->quote_count,
                    'source' => $lead->source,
                    'created_at' => $lead->created_at->toIso8601String(),
                ],
            ];

            $response = Http::timeout(10)->post($url, $payload);

            if (!$response->successful()) {
                Log::warning('Webhook lead failed', [
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Webhook lead error', [
                'url' => config('seo.webhook_leads_url'),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
