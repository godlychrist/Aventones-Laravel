<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Reserva Pendientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .alert-badge {
            background: #ff6b6b;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .info-box {
            background: #f0f7ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .booking-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .booking-card h3 {
            margin: 0 0 15px 0;
            color: #667eea;
            font-size: 18px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }
        .booking-detail {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f5f5f5;
        }
        .booking-detail:last-child {
            border-bottom: none;
        }
        .booking-detail .label {
            font-weight: bold;
            color: #666;
        }
        .booking-detail .value {
            color: #333;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: transform 0.2s;
        }
        .button:hover {
            transform: translateY(-2px);
        }
        .footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #e0e0e0;
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #667eea, transparent);
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚗 Solicitudes de Reserva Pendientes</h1>
            <div class="alert-badge">
                {{ $bookings->count() }} {{ $bookings->count() === 1 ? 'Solicitud' : 'Solicitudes' }} Pendiente{{ $bookings->count() === 1 ? '' : 's' }}
            </div>
        </div>
        
        <div class="content">
            <p class="greeting">Hola <strong>{{ $driver->name }} {{ $driver->lastname }}</strong>,</p>
            
            <div class="info-box">
                <p style="margin: 0;">
                    <strong>⏰ Recordatorio importante:</strong> Tienes 
                    <strong>{{ $bookings->count() }}</strong> 
                    {{ $bookings->count() === 1 ? 'solicitud de reserva' : 'solicitudes de reserva' }} 
                    que {{ $bookings->count() === 1 ? 'lleva' : 'llevan' }} más de 
                    <strong>{{ $minutes }} minutos</strong> sin respuesta.
                </p>
            </div>

            <p>Por favor, revisa y responde a {{ $bookings->count() === 1 ? 'esta solicitud' : 'estas solicitudes' }} lo antes posible:</p>

            <div class="divider"></div>

            @foreach($bookings as $index => $booking)
            <div class="booking-card">
                <h3>Reserva #{{ $booking->id }}</h3>
                
                <div class="booking-detail">
                    <span class="label">👤 Pasajero:</span>
                    <span class="value">
                        @php
                            $passenger = \App\Models\User::where('cedula', $booking->user_id)->first();
                        @endphp
                        {{ $passenger ? $passenger->name . ' ' . $passenger->lastname : 'Usuario ID: ' . $booking->user_id }}
                    </span>
                </div>

                <div class="booking-detail">
                    <span class="label">📧 Email del pasajero:</span>
                    <span class="value">{{ $passenger ? $passenger->email : 'N/A' }}</span>
                </div>

                <div class="booking-detail">
                    <span class="label">📞 Teléfono:</span>
                    <span class="value">{{ $passenger ? $passenger->phoneNum : 'N/A' }}</span>
                </div>

                <div class="booking-detail">
                    <span class="label">🚗 Viaje ID:</span>
                    <span class="value">#{{ $booking->ride_id }}</span>
                </div>

                <div class="booking-detail">
                    <span class="label">📅 Fecha de reserva:</span>
                    <span class="value">{{ $booking->date }}</span>
                </div>

                <div class="booking-detail">
                    <span class="label">🕐 Creada hace:</span>
                    <span class="value">
                        {{ \Carbon\Carbon::parse($booking->created_at)->diffForHumans() }}
                    </span>
                </div>

                <div class="booking-detail">
                    <span class="label">Estado:</span>
                    <span class="value">
                        <span class="status-pending">{{ strtoupper($booking->status) }}</span>
                    </span>
                </div>
            </div>
            @endforeach

            <div class="divider"></div>

            <div class="button-container">
                <a href="{{ url('/') }}" class="button">
                    Ver Mis Reservas
                </a>
            </div>

            <p style="color: #666; font-size: 14px; margin-top: 30px;">
                <strong>Nota:</strong> Es importante que respondas a estas solicitudes para mantener una buena experiencia 
                con los pasajeros y mejorar tu reputación como conductor en Aventones.
            </p>

            <p style="margin-top: 30px;">
                Saludos,<br>
                <strong>El equipo de Aventones</strong>
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Aventones. Todos los derechos reservados.</p>
            <p style="margin-top: 10px;">
                Este es un correo automático, por favor no respondas a este mensaje.
            </p>
        </div>
    </div>
</body>
</html>
