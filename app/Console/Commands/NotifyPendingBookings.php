<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bookings;
use App\Models\User;
use App\Mail\PendingBookingsNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class NotifyPendingBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:notify-pending {minutes=30 : Número de minutos desde la creación}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifica a los choferes sobre solicitudes de reserva pendientes que tienen más de X minutos sin respuesta';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener el número de minutos desde los argumentos (por defecto 30)
        $minutes = $this->argument('minutes');
        
        $this->info("Buscando reservas pendientes con más de {$minutes} minutos...");

        // Calcular la fecha/hora límite
        $timeLimit = Carbon::now()->subMinutes($minutes);

        // Buscar todas las reservas pendientes creadas antes del límite de tiempo
        $pendingBookings = Bookings::where('status', 'pending')
            ->where('created_at', '<=', $timeLimit)
            ->whereNotNull('created_at')
            ->with(['driver', 'ride']) // Eager loading para optimizar
            ->get();

        if ($pendingBookings->isEmpty()) {
            $this->info('No se encontraron reservas pendientes.');
            return 0;
        }

        $this->info("Se encontraron {$pendingBookings->count()} reservas pendientes.");

        // Agrupar las reservas por chofer
        $bookingsByDriver = $pendingBookings->groupBy('driver_id');

        $emailsSent = 0;
        $emailsFailed = 0;

        // Enviar un correo a cada chofer con todas sus reservas pendientes
        foreach ($bookingsByDriver as $driverId => $bookings) {
            try {
                // Obtener información del chofer
                $driver = User::where('cedula', $driverId)->first();

                if (!$driver || !$driver->email) {
                    $this->warn("Chofer con ID {$driverId} no encontrado o sin email.");
                    $emailsFailed++;
                    continue;
                }

                // Enviar el correo
                Mail::to($driver->email)->send(
                    new PendingBookingsNotification($driver, $bookings, $minutes)
                );

                $emailsSent++;
                $this->info("✓ Email enviado a {$driver->name} {$driver->lastname} ({$driver->email}) - {$bookings->count()} reserva(s)");

            } catch (\Exception $e) {
                $emailsFailed++;
                $this->error("✗ Error al enviar email al chofer ID {$driverId}: " . $e->getMessage());
            }
        }

        // Resumen
        $this->newLine();
        $this->info("========== RESUMEN ==========");
        $this->info("Total de reservas pendientes: {$pendingBookings->count()}");
        $this->info("Emails enviados exitosamente: {$emailsSent}");
        
        if ($emailsFailed > 0) {
            $this->warn("Emails fallidos: {$emailsFailed}");
        }
        
        $this->info("============================");

        return 0;
    }
}
