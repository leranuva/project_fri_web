<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización de Importación</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 0;
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            padding: 2rem;
            text-align: center;
            color: white;
        }
        .email-header h1 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
        }
        .email-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }
        .email-body {
            padding: 2rem;
        }
        .quote-section {
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .quote-section h3 {
            margin: 0 0 1rem 0;
            color: #667eea;
            font-size: 1.125rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .quote-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .quote-item:last-child {
            border-bottom: none;
        }
        .quote-label {
            font-weight: 500;
            color: #666;
        }
        .quote-value {
            font-weight: 600;
            color: #333;
        }
        .quote-total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 1.5rem;
        }
        .quote-total-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .quote-total-label {
            font-size: 1.25rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .quote-total-amount {
            font-size: 2rem;
            font-weight: 800;
        }
        .email-footer {
            padding: 1.5rem 2rem;
            background: #f9f9f9;
            text-align: center;
            color: #666;
            font-size: 0.875rem;
        }
        .message-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Cotización de Importación</h1>
            <p>Detalles de su cotización personalizada</p>
        </div>
        
        <div class="email-body">
            @if($message)
            <div class="message-box">
                <p style="margin: 0; color: #1976d2;">{{ $message }}</p>
            </div>
            @endif

            {{-- Información del Producto --}}
            <div class="quote-section">
                <h3>Información del Producto</h3>
                <div class="quote-item">
                    <span class="quote-label">Producto:</span>
                    <span class="quote-value">{{ $quoteData['productName'] ?? $quoteData['product'] ?? 'N/A' }}</span>
                </div>
                <div class="quote-item">
                    <span class="quote-label">Cantidad:</span>
                    <span class="quote-value">{{ $quoteData['quantity'] ?? 0 }}</span>
                </div>
                <div class="quote-item">
                    <span class="quote-label">Peso Total:</span>
                    <span class="quote-value">{{ number_format($quoteData['weight'] ?? 0, 2) }} lb</span>
                </div>
            </div>

            {{-- Costos --}}
            <div class="quote-section">
                <h3>Costos</h3>
                <div class="quote-item">
                    <span class="quote-label">Valor del Producto:</span>
                    <span class="quote-value">${{ number_format($quoteData['productCost'] ?? 0, 2) }}</span>
                </div>
                <div class="quote-item">
                    <span class="quote-label">Valor del Envío:</span>
                    <span class="quote-value">${{ number_format($quoteData['shippingCost'] ?? 0, 2) }}</span>
                </div>
                <div class="quote-item">
                    <span class="quote-label">Seguro CIF:</span>
                    <span class="quote-value">${{ number_format($quoteData['seguroCIF'] ?? 0, 2) }}</span>
                </div>
            </div>

            {{-- Desglose de Impuestos --}}
            <div class="quote-section">
                <h3>Desglose de Impuestos</h3>
                <div class="quote-item">
                    <span class="quote-label">Ad-valorem ({{ number_format(($quoteData['adValorem'] ?? 0) * 100, 0) }}%):</span>
                    <span class="quote-value">${{ number_format($quoteData['impuestoAdvalorem'] ?? 0, 2) }}</span>
                </div>
                <div class="quote-item">
                    <span class="quote-label">Fodinfa ({{ number_format(($quoteData['fodinfa'] ?? 0) * 100, 1) }}%):</span>
                    <span class="quote-value">${{ number_format($quoteData['impuestoFodinfa'] ?? 0, 2) }}</span>
                </div>
                <div class="quote-item">
                    <span class="quote-label">IVA ({{ number_format(($quoteData['iva'] ?? 0) * 100, 0) }}%):</span>
                    <span class="quote-value">${{ number_format($quoteData['impuestoIva'] ?? 0, 2) }}</span>
                </div>
                <div class="quote-item">
                    <span class="quote-label">Arancel Específico:</span>
                    <span class="quote-value">${{ number_format($quoteData['arancelEspecifico'] ?? 0, 2) }}</span>
                </div>
                <div class="quote-item" style="margin-top: 0.5rem; padding-top: 1rem; border-top: 2px solid #667eea;">
                    <span class="quote-label" style="font-weight: 600; font-size: 1.1rem;">Total Impuestos:</span>
                    <span class="quote-value" style="font-weight: 700; font-size: 1.1rem;">${{ number_format($quoteData['totalImpuestos'] ?? 0, 2) }}</span>
                </div>
            </div>

            {{-- Total Final --}}
            <div class="quote-total">
                <div class="quote-total-content">
                    <div class="quote-total-label">Total de la Cotización</div>
                    <div class="quote-total-amount">${{ number_format($quoteData['totalCotizacion'] ?? 0, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="email-footer">
            <p style="margin: 0;">Este email fue generado automáticamente por el sistema de cotizaciones.</p>
            <p style="margin: 0.5rem 0 0 0;">Por favor, consulte el PDF adjunto para más detalles.</p>
        </div>
    </div>
</body>
</html>





