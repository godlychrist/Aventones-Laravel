<?php
namespace App\Http\Controllers;

use App\Http\Requests\RideRequest;
use App\Models\Ride;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RidesController extends Controller
{
    /**
     * Display a paginated list of rides
     * 
     * @param Request $request The HTTP request
     * @return View The rides list view
     */
    public function index(Request $request): View
    {
        $rides = Ride::where('user_id', Auth::user()->cedula)->paginate(10);

        return view('Rides.showRides', compact('rides'))
            ->with('i', ($request->input('page', 1) - 1) * $rides->perPage());
    }

    /**
     * Show the form for creating a new ride
     * 
     * @return View The ride creation form view
     */
    public function create(): View
    {
        $user = Auth::user();
        $vehicles = Vehicle::where('user_id', $user->cedula)->get();
        return view('Rides/createRides', compact('vehicles', 'user'));
    }

    /**
     * Store a newly created ride in the database
     * 
     * @param RideRequest $request The validated ride request
     * @return RedirectResponse Redirects back to registration with success message
     */
    public function store(RideRequest $request): RedirectResponse
    {

        $data = $request->validated();

        Ride::create([
            'name'             => $data['name'],
            'origin'             => $data['origin'],
            'destination'         => $data['destination'],
            'date'        => $data['date'],
            'time'            => $data['time'],
            'space_cost'         => $data['space_cost'],
            'space'         => $data['space'],
            'user_id'         => $data['user_id'],
            'vehicle_id'         => $data['vehicle_id'],
            'status'         => $data['status'],
        ]);

        return redirect()->route('rides')
            ->with('success', 'Viaje registrado correctamente.');
    }

    /**
     * Display the specified ride
     * 
     * @param int $id The ride ID
     * @return View The ride detail view
     */
    public function show($id): View
    {
        $ride = Ride::find($id);
        return view('Rides.showRides', compact('ride'));
    }

    /**
     * Show the form for editing the specified ride
     * 
     * @param string $cedula The driver's cedula (ID number)
     * @return View The ride edit form view
     */
    public function edit($id): View
    {
        $ride = Ride::where('id', $id)->firstOrFail();
        $user = Auth::user();
        $vehicles = Vehicle::where('user_id', $user->cedula)->get();
        return view('Rides.editRides', compact('ride', 'vehicles'));
    }

    /**
     * Update the specified ride in the database
     * 
     * @param RideRequest $request The validated ride request
     * @param string $id The ride's ID
     * @return RedirectResponse Redirects to rides list with success message
     */
    public function update(RideRequest $request, $id): RedirectResponse
    {

        $ride = Ride::where('id', $id)->firstOrFail();
        $data   = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('drivers', 'public');
        }

        $ride->update($data);

        return redirect()->route('rides')
            ->with('success', 'Viaje actualizado correctamente.');
    }

    /**
     * Remove the specified ride from the database
     * 
     * @param string $id The ride's ID
     * @return RedirectResponse Redirects to rides list with success message
     */
    public function destroy($id): RedirectResponse
    {
        Ride::where('id', $id)->delete();
        return redirect()->route('rides')
            ->with('success', 'Viaje eliminado correctamente.');
    }
}
