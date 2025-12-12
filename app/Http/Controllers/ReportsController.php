<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReportsController extends Controller
{
    /**
     * Display the search reports page with filters.
     */
    public function searchReports(Request $request): View
    {
        // Verify user is admin
        if (strtolower(trim(Auth::user()->userType)) !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Build query
        $query = Movement::with('user');

        // Apply date filters if provided
        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        // Order by most recent first
        $movements = $query->orderBy('date', 'desc')
                          ->orderBy('id', 'desc')
                          ->paginate(20);

        // Calculate statistics
        $totalSearches = $movements->total();
        $avgResults = $movements->avg('resultsNum');

        return view('Reports.SearchReports', [
            'movements' => $movements,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalSearches' => $totalSearches,
            'avgResults' => round($avgResults, 2),
        ]);
    }

    /**
     * Export search reports to CSV.
     */
    public function exportSearchReports(Request $request)
    {
        // Verify user is admin
        if (strtolower(trim(Auth::user()->userType)) !== 'admin') {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Build query
        $query = Movement::with('user');

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $movements = $query->orderBy('date', 'desc')->get();

        // Generate CSV
        $filename = 'reporte_busquedas_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($movements) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            fputcsv($file, [
                'Fecha',
                'Usuario (Cédula)',
                'Nombre Usuario',
                'Lugar de Salida',
                'Lugar de Llegada',
                'Cantidad de Resultados'
            ]);

            // Add data
            foreach ($movements as $movement) {
                fputcsv($file, [
                    $movement->date,
                    $movement->user_id,
                    $movement->user ? $movement->user->name . ' ' . $movement->user->lastname : 'Usuario no encontrado',
                    $movement->leavePlace ?: 'Todos',
                    $movement->destinationPlace ?: 'Todos',
                    $movement->resultsNum
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
