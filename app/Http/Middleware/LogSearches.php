<?php

namespace App\Http\Middleware;

use App\Models\Movement;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogSearches
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log if user is authenticated and there are search parameters
        if (Auth::check() && ($request->has('origin') || $request->has('destination') || $request->has('date'))) {
            
            // Get the number of results from the view data
            $resultsNum = 0;
            
            // Try to extract results count from the response
            if ($response instanceof \Illuminate\Http\Response) {
                $content = $response->getOriginalContent();
                if (isset($content['rides'])) {
                    $resultsNum = is_countable($content['rides']) ? count($content['rides']) : 0;
                }
            }

            Movement::create([
                'user_id' => Auth::user()->cedula,
                'date' => now()->format('Y-m-d'),
                'leavePlace' => $request->input('origin', ''),
                'destinationPlace' => $request->input('destination', ''),
                'resultsNum' => $resultsNum,
            ]);
        }

        return $response;
    }
}
