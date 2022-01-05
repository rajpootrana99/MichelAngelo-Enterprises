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
            'user_id' => 1,
            'service_id' => $request->input('service_id'),
        ]);
        return response()->json($booking);
    }
}
