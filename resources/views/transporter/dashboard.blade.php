@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2>Welcome, {{ auth('transporter')->user()->name }} (Transporter)</h2>
            <a href="{{ route('transporter.vehicles.create') }}" class="btn btn-success btn-lg mb-4">
                Add New Vehicle
            </a>
        </div>
    </div>

    <div class="row">
        @foreach(auth('transporter')->user()->vehicles as $vehicle)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($vehicle->photos->first())
                        <img src="{{ asset('storage/vehicles/' . $vehicle->photos->first()->path) }}" class="card-img-top" height="200">
                    @endif
                    <div class="card-body">
                        <h5>{{ $vehicle->name }}</h5>
                        <p>{{ $vehicle->city }} • {{ $vehicle->seats }} seats</p>
                        <p class="text-success fw-bold">PKR {{ $vehicle->base_rate }}/day</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection