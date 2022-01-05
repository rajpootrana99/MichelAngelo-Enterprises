<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('booking.index');
    }

    public function fetchBookings(){
        $bookings = Booking::with('user', 'service')->get();
        return response()->json([
            'status' => true,
            'bookings' => $bookings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    public function bookBooking($booking){
        $booking = Booking::find($booking);
        if ($booking->status == 'Pending' || $booking->status == 'Reject'){
            $value = 1;
        }
        else if($booking->status == 'Complete'){
            $value = 3;
        }
        else if($booking->status == 'Booked'){
            $value = 3;
        }
        else {
            $value = 0;
        }
        $booking->update([
            'status' => $value,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Status changed successfully',
        ]);
    }

    public function rejectBooking($booking){
        $booking = Booking::find($booking);
        if ($booking->status == 'Pending' || $booking->status == 'Booked'){
            $value = 2;
        }
        else if($booking->status == 'Complete'){
            $value = 3;
        }
        else {
            $value = 0;
        }
        $booking->update([
            'status' => $value,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Status changed successfully',
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy($booking)
    {
        $booking = Booking::find($booking);
        if (!$booking){
            return response()->json([
                'status' => 0,
                'message' => 'Booking not exist',
            ]);
        }
        $booking->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Booking deleted successfully',
        ]);
    }
}
