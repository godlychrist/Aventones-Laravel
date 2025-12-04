<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magic Link - Aventones</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 32px;
            font-weight: 800;
            color: #000;
            margin-bottom: 10px;
        }
        h1 {
            color: #000;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 16px 32px;
            background-color: #000;
            color: white !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #333;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #999;
            font-size: 12px;
        }
        .alternative-link {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            word-break: break-all;
        }
        .alternative-link p {
            margin: 5px 0;
            font-size: 12px;
        }
        .alternative-link a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🚗 Aventones</div>
        </div>

        <h1>¡Hola!</h1>
        
        <p>Recibimos una solicitud para acceder a tu cuenta de Aventones sin contraseña.</p>
        
        <p>Haz clic en el botón de abajo para iniciar sesión automáticamente:</p>

        <div style="text-align: center;">
            <a href="{{ $loginUrl }}" class="button">
                Iniciar Sesión
            </a>
        </div>

        <div class="warning">
            <p><strong>⚠️ Importante:</strong></p>
            <p>• Este enlace es de un solo uso y expira en 15 minutos</p>
            <p>• No compartas este enlace con nadie</p>
            <p>• Si no solicitaste este acceso, ignora este correo</p>
        </div>

        <div class="alternative-link">
            <p><strong>¿El botón no funciona?</strong></p>
            <p>Copia y pega este enlace en tu navegador:</p>
            <p><a href="{{ $loginUrl }}">{{ $loginUrl }}</a></p>
        </div>

        <div class="footer">
            <p>Este correo fue enviado a {{ $email }}</p>
            <p>© {{ date('Y') }} Aventones. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
