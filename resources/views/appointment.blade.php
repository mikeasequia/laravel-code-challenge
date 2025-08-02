@extends('index')


@section('childContent')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        @foreach ($appointments as $a)
                            <div class="navbar-auth mb-2">
                                {{ $a->name }}
                                <a class="btn btn-primary" href="/appointments/{{$a->id}}">
                                    View
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($appointment)
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header text-white"
                            style="background-color: {{ $appointment->state == 'approved' ? 'green' : ($appointment->state == 'rejected' ? 'red' : 'orange') }};">
                            <h4 class="mb-0">Name: {{ $appointment->name }}</h4>
                            <h5 class="mb-0">Status: {{ $appointment->state }}</h5>
                        </div>
                        <div class="card-body">
                            @if(in_array('submitted', App\Models\Appointment::$states[$appointment->state]))
                                <form method="POST" action="{{ route('appointments.submit', $appointment) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            @endif

                            <div class="justify-center d-flex">
                                @if(in_array('approved', App\Models\Appointment::$states[$appointment->state]))
                                    <form method="POST" action="{{ route('appointments.approve', $appointment) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success me-1">Approve</button>
                                    </form>
                                @endif

                                @if(in_array('rejected', App\Models\Appointment::$states[$appointment->state]))
                                    <form method="POST" action="{{ route('appointments.reject', $appointment) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </form>
                                @endif
                            </div>                            
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection