<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
   
    public function index()
    {
        $bookings = Booking::with('service')
            ->where('user_id', Auth::id())
            ->orderBy('booking_date', 'desc')->get();
        return view('customer.booking.index', compact('bookings'));
    }

    public function create()
    {
        $services = Services::all(); 
        return view('bookings.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',

        ]);
        $bookingDateTime = $request->booking_date . ' ' . $request->time_slot;
        $existingBooking = Booking::where('service_id', $request->service_id)
            ->whereDate('booking_date', $request->booking_date)
            ->whereBetween('booking_date', [

                Carbon::parse($bookingDateTime)->subMinutes(30),
                Carbon::parse($bookingDateTime)->addMinutes(30)
            ])
            ->exists();

        if ($existingBooking) {
            return back()->withErrors(['error' => 'This service is already booked within 30 minutes of the selected time.']);
        }
        Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'booking_date' => $bookingDateTime,
            'time_slot' => $request->time_slot,
            'status' => 'Scheduled',
        ]);

        return redirect()->route('customer-bookings.index')->with('success', 'Booking successfully created.');
    }
    public function destroy($id)
    {
  
        $booking = Booking::where('customer_id', Auth::id())->findOrFail($id);
    
        
        $booking->update(['status' => 'Cancelled']);
    
        // إعادة توجيه المستخدم مع رسالة نجاح
        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully!');
    }
    
    
}
