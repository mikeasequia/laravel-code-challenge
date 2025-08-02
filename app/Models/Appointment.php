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
}