<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Flat Rate Imports</title>
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
            padding: 2.5rem 2rem;
            text-align: center;
            color: white;
        }
        .email-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .email-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.95;
            font-size: 1.1rem;
        }
        .email-body {
            padding: 2.5rem 2rem;
        }
        .welcome-message {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border-left: 4px solid #667eea;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 8px;
        }
        .welcome-message h2 {
            margin: 0 0 1rem 0;
            color: #667eea;
            font-size: 1.5rem;
        }
        .welcome-message p {
            margin: 0.5rem 0;
            color: #555;
            font-size: 1rem;
        }
        .features-section {
            margin: 2rem 0;
        }
        .features-section h3 {
            color: #667eea;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .feature-item {
            display: flex;
            align-items: flex-start;
            padding: 1rem;
            margin-bottom: 0.75rem;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 3px solid #667eea;
        }
        .feature-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: #667eea;
        }
        .feature-content h4 {
            margin: 0 0 0.5rem 0;
            color: #333;
            font-size: 1.1rem;
        }
        .feature-content p {
            margin: 0;
            color: #666;
            font-size: 0.95rem;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            margin: 1.5rem 0;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .cta-container {
            text-align: center;
            margin: 2rem 0;
        }
        .email-footer {
            padding: 1.5rem 2rem;
            background: #f9f9f9;
            text-align: center;
            color: #666;
            font-size: 0.875rem;
            border-top: 1px solid #e0e0e0;
        }
        .email-footer p {
            margin: 0.5rem 0;
        }
        .social-links {
            margin-top: 1rem;
        }
        .social-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 0.5rem;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>¡Bienvenido a Flat Rate Imports!</h1>
            <p>Tu cuenta ha sido verificada exitosamente</p>
        </div>
        
        <div class="email-body">
            <div class="welcome-message">
                <h2>Hola {{ $user->name }},</h2>
                <p>¡Estamos emocionados de tenerte con nosotros!</p>
                <p>Tu correo electrónico ha sido verificado y tu cuenta está lista para usar. Ahora puedes acceder a todos los servicios que ofrecemos para facilitar tus importaciones.</p>
            </div>

            <div class="features-section">
                <h3>¿Qué puedes hacer ahora?</h3>
                
                <div class="feature-item">
                    <div class="feature-icon">📦</div>
                    <div class="feature-content">
                        <h4>Cotizaciones Instantáneas</h4>
                        <p>Obtén cotizaciones detalladas de tus importaciones en tiempo real, con desglose completo de costos e impuestos.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">📊</div>
                    <div class="feature-content">
                        <h4>Seguimiento de Envíos</h4>
                        <p>Rastrea el estado de tus importaciones en tiempo real desde nuestro sistema de tracking.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">💼</div>
                    <div class="feature-content">
                        <h4>Panel de Control</h4>
                        <p>Gestiona todas tus importaciones desde tu dashboard personalizado.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">📧</div>
                    <div class="feature-content">
                        <h4>Soporte Personalizado</h4>
                        <p>Nuestro equipo está listo para ayudarte con cualquier consulta sobre tus importaciones.</p>
                    </div>
                </div>
            </div>

            <div class="cta-container">
                <a href="{{ route('dashboard') }}" class="cta-button">Acceder a mi Dashboard</a>
            </div>

            <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 8px; margin-top: 2rem;">
                <p style="margin: 0 0 0.5rem 0; color: #333; font-weight: 600;">¿Necesitas ayuda?</p>
                <p style="margin: 0; color: #666; font-size: 0.95rem;">
                    Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos. Estamos aquí para ayudarte a hacer que tus importaciones sean más fáciles y eficientes.
                </p>
            </div>
        </div>

        <div class="email-footer">
            <p style="margin: 0; font-weight: 600; color: #333;">Flat Rate Imports</p>
            <p style="margin: 0.5rem 0;">Tu socio confiable en importaciones</p>
            <p style="margin: 0.5rem 0;">
                <a href="{{ config('app.url') }}">www.flatrateimports.com</a>
            </p>
            <div class="social-links">
                <p style="margin: 0.5rem 0 0 0; color: #999; font-size: 0.8rem;">
                    Este es un correo automático, por favor no respondas a este mensaje.
                </p>
            </div>
        </div>
    </div>
</body>
</html>

