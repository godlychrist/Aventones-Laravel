<?php
// ...existing code...


namespace App\Http\Controllers;

use App\Http\Requests\RideRequest;
use App\Models\Ride;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RidesController extends Controller
{
    // ...existing code...

    /**
     * MIS RIDES (del driver logueado)
     */
    public function index(Request $request): View
    {
        $rides = Ride::where('user_id', Auth::user()->cedula)->paginate(10);

        return view('Rides.showRides', compact('rides'))
            ->with('i', ($request->input('page', 1) - 1) * $rides->perPage());
    }

    /**
     * RIDES DISPONIBLES PARA PASAJEROS (pantalla /index / welcome)
     */
    public function available(Request $request): View
    {
        // valores de filtro que vienen por GET
        $selectedOrigin      = $request->input('origin');
        $selectedDestination = $request->input('destination');
        $selectedDate        = $request->input('date');

        // base: solo rides activos
        $query = Ride::where('status', 'active');

        if ($selectedOrigin) {
            $query->where('origin', $selectedOrigin);
        }

        if ($selectedDestination) {
            $query->where('destination', $selectedDestination);
        }

        if ($selectedDate) {
            $query->whereDate('date', $selectedDate);
        }

        // rides filtrados para la tabla
        $rides = $query->orderBy('date')->orderBy('time')->get();

        // para llenar los selects (sin repetir valores) y ordenados
        $origins = Ride::where('status', 'active')
            ->select('origin')->distinct()->orderBy('origin')->pluck('origin');

        $destinations = Ride::where('status', 'active')
            ->select('destination')->distinct()->orderBy('destination')->pluck('destination');

        return view('welcome', [
            'rides'               => $rides,
            'origins'             => $origins,
            'destinations'        => $destinations,
            'selectedOrigin'      => $selectedOrigin,
            'selectedDestination' => $selectedDestination,
            'selectedDate'        => $selectedDate,
        ]);
    }

    /**
     * FORM CREAR RIDE
     */
    public function create(): View
    {
        $user     = Auth::user();
        $vehicles = Vehicle::where('user_id', $user->cedula)->get();
        return view('Rides/createRides', compact('vehicles', 'user'));
    }

    /**
     * GUARDAR RIDE
     */
    public function store(RideRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Ride::create([
            'name'        => $data['name'],
            'origin'      => $data['origin'],
            'destination' => $data['destination'],
            'date'        => $data['date'],
            'time'        => $data['time'],
            'space_cost'  => $data['space_cost'],
            'space'       => $data['space'],
            'user_id'     => $data['user_id'],
            'vehicle_id'  => $data['vehicle_id'],
            'status'      => $data['status'],
        ]);

        return redirect()->route('rides')
            ->with('success', 'Viaje registrado correctamente.');
    }

    public function show($id): View
    {
        $ride = Ride::find($id);
        return view('Rides.showRides', compact('ride'));
    }

    public function edit($id): View
    {
        $ride     = Ride::where('id', $id)->firstOrFail();
        $user     = Auth::user();
        $vehicles = Vehicle::where('user_id', $user->cedula)->get();

        return view('Rides.editRides', compact('ride', 'vehicles'));
    }

    public function update(RideRequest $request, $id): RedirectResponse
    {
        $ride = Ride::where('id', $id)->firstOrFail();
        $data = $request->validated();

        $ride->update($data);

        return redirect()->route('rides')
            ->with('success', 'Viaje actualizado correctamente.');
    }

    public function destroy($id): RedirectResponse
    {
        Ride::where('id', $id)->delete();

        return redirect()->route('rides')
            ->with('success', 'Viaje eliminado correctamente.');
    }
}