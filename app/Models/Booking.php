<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'status',
        'date',
    ];

    public function getStatusAttribute($attribute){
        return $this->statusOptions()[$attribute] ?? 0;
    }

    public function statusOptions(){
        return [
            4 => 'Expire',
            3 => 'Complete',
            2 => 'Reject',
            1 => 'Booked',
            0 => 'Pending',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
