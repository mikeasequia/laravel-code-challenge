<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    public function index()
    {
        $appointment = null;
        $appointments = Appointment::all();
        return view('appointment', [
            'appointments' => $appointments,
            'appointment' => $appointment,
        ]);
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointments = Appointment::all();
        return view('appointment', [            
            'appointments' => $appointments,
            'appointment' => $appointment,
        ]);
    }

    public function submit(Appointment $appointment)
    {
        $appointment->transitionTo('submitted');
        return redirect()->back()->with('status', 'Appointment submitted!');
    }

    public function approve(Appointment $appointment)
    {
        $appointment->transitionTo('approved');
        return redirect()->back()->with('status', 'Appointment approved!');
    }

    public function reject(Appointment $appointment)
    {
        $appointment->transitionTo('rejected');
        return redirect()->back()->with('status', 'Appointment rejected!');
    }
}
