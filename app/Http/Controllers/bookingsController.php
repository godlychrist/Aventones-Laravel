<?php
namespace App\Http\Controllers;

use App\Http\Requests\BookingsRequest;
use App\Models\Bookings;
use App\Models\Ride;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;


class BookingsController extends Controller
{

    /**
     * Display a paginated list of bookings
     * 
     * @param Request $request The HTTP request
     * @return View The bookings list view
     */
    public function index(Request $request): View
    {
        $bookings = Bookings::paginate(10);

        return view('Bookings.ShowBookings', compact('bookings'))
            ->with('i', ($request->input('page', 1) - 1) * $bookings->perPage());
    }

    /**
     * Show the form for creating a new booking
     * 
     * @param int $ride_id The ride ID to book
     * @return View The booking registration form view
     */
    public function create($ride_id): View
    {
        $booking = new Bookings();
        $ride = null;
        
        // Load the ride data
        if ($ride_id) {
            $ride = Ride::findOrFail($ride_id);
            
            // Pre-fill booking data from the ride
            $booking->ride_id = $ride->id;
            $booking->driver_id = $ride->user_id;
            $booking->date = $ride->date;
            $booking->user_id = Auth::user()->cedula;
            $booking->status = 'pending';
        }
        
        return view('Bookings.RegisterBookings', compact('booking', 'ride'));
    }

    /**
     * Store a newly created booking in the database
     * 
     * @param BookingsRequest $request The validated booking request
     * @return RedirectResponse Redirects back to bookings list with success message
     */
    public function store(BookingsRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $bookings = Bookings::create([
            'user_id' => $data['user_id'],
            'status' => $data['status'],
            'ride_id' => $data['ride_id'],
            'date' => $data['date'],
            'driver_id' => $data['driver_id'],
            'created_at' => now(), // ← Agregar timestamp para el sistema de notificaciones
        ]);

        $ride = Ride::findOrFail($data['ride_id']);
        $ride->update([
            'status' => 'booked',
        ]);

        return redirect()->route('bookings')
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified booking
     * 
     * @param int $id The booking ID
     * @return View The booking detail view
     */
    public function show($id): View
    {
        $booking = Bookings::findOrFail($id);
        return view('Bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking
     * 
     * @param int $id The booking ID
     * @return View The booking edit form view
     */
    public function edit($id): View
    {
        $booking = Bookings::findOrFail($id);
        $ride = Ride::findOrFail($booking->ride_id);
        return view('Bookings.edit', compact('booking', 'ride'));
    }

    /**
     * Update the specified booking in the database
     * 
     * @param BookingsRequest $request The validated booking request
     * @param int $id The booking ID
     * @return RedirectResponse Redirects to bookings list with success message
     */
    public function update(BookingsRequest $request, $id): RedirectResponse
    {
        $booking = Bookings::findOrFail($id);
        $data = $request->validated();

        $booking->update($data);

        return Redirect::route('Bookings.showBookings')
            ->with('success', 'Booking updated successfully');
    }

    /**
     * Remove the specified booking from the database
     * 
     * @param int $id The booking ID
     * @return RedirectResponse Redirects to bookings list with success message
     */
    public function destroy($id): RedirectResponse
    {
        Bookings::findOrFail($id)->delete();
        return Redirect::route('showBookings')
            ->with('success', 'Booking deleted successfully');
    }
    /**
     * Update the status of the specified booking
     * 
     * @param Request $request The HTTP request
     * @param int $id The booking ID
     * @return RedirectResponse Redirects back with success message
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $booking = Bookings::findOrFail($id);
        $status = $request->input('status');
        
        if (in_array($status, ['confirmed', 'rejected', 'cancelled'])) {
            $booking->update(['status' => $status]);
            
            $message = 'Booking status updated successfully.';
            if ($status == 'confirmed') $message = 'Booking accepted successfully.';
            if ($status == 'rejected') $message = 'Booking rejected successfully.';
            if ($status == 'cancelled') $message = 'Booking cancelled successfully.';
            
            return redirect()->back()->with('success', $message);
        }
        
        return redirect()->back()->with('error', 'Invalid status update.');
    }
}