<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
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
        $bookings = Booking::with('service')->where('user_id', Auth::id())->get();
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
        $date = Carbon::make($request->input('date'))->format("Y-m-d");
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $request->input('service_id'),
            'date' => $date,
        ]);
        return response()->json($booking);
    }
}
