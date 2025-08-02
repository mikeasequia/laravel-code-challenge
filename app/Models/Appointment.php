<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\StateMachine;

class Appointment extends Model
{
    use StateMachine;

    public static $states = [
        'draft' => ['submitted'],
        'submitted' => ['approved', 'rejected'],
        'approved' => [],
        'rejected' => [],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}