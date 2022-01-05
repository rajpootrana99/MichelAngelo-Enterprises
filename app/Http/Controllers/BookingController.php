<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function createBooking(Request $request){
        $validator = Validator::make($request->all(),[
            'service_id' => 'required',
        ]);
        if($validator->fails()){
            $message = $validator->errors();
            return response([
                'status' => false,
                'message' =>$message->first()
            ],401);
        }
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $request->input('service_id'),
        ]);
        return response()->json($booking);
    }

    public function fetchBookings(){
        $bookings = Booking::with('service')->where('user_id', Auth::id());
        return response()->json($bookings);
    }

    public function scheduleBooking(Request $request){
        $validator = Validator::make($request->all(),[
            'service_id' => 'required',
            'date' => 'required',
        ]);
        if($validator->fails()){
            $message = $validator->errors();
            return response([
                'status' => false,
                'message' =>$message->first()
            ],401);
        }
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $request->input('service_id'),
            'date' => $request->input('date'),
        ]);
        return response()->json($booking);
    }
}
