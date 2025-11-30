<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Aventones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>¡Bienvenido a Aventones!</h1>
    </div>
    <div class="content">
        <p>Hola <strong>{{ $user->name }} {{ $user->lastname }}</strong>,</p>
        
        <p>Gracias por registrarte en Aventones. Tu cuenta ha sido creada exitosamente.</p>
        
        <p>Para activar tu cuenta, por favor haz clic en el siguiente enlace:</p>
        
        <center>
            <a href="{{ url('activate/' . $user->token) }}" class="button">Activar mi cuenta</a>
        </center>
        
        <p><small>Este enlace expirará en 1 hora.</small></p>
        
        <p>Si no solicitaste esta cuenta, puedes ignorar este correo.</p>
        
        <p>Saludos,<br>El equipo de Aventones</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Aventones. Todos los derechos reservados.</p>
    </div>
</body>
</html>