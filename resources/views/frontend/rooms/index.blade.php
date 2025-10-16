@extends('frontend.layouts.app')

@section('title', 'Rooms & Suites - Elisyan Suites')
@section('description', 'Explore our luxurious rooms and suites at Elisyan Suites. Choose from deluxe rooms, executive suites, and presidential suites.')

@section('content')
    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-4.0.3') center/cover; height: 400px; display: flex; align-items: center; color: white; text-align: center;">
        <div class="container">
            <h1 class="display-3 fw-bold">Rooms & Suites</h1>
            <p class="lead">Choose from our exquisite collection of luxury accommodations</p>
        </div>
    </section>

    <!-- Rooms Section -->
    <section class="rooms-section">
        <div class="container">
            <div class="section-title">
                <h2>Luxury Rooms & Suites</h2>
                <p class="lead">Choose from our exquisite collection of rooms and suites</p>
            </div>
            <div class="row">
                @foreach($roomTypes as $roomType)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="room-card">
                        <img src="{{ $roomType->roomImages->first()->image_path ?? 'https://via.placeholder.com/800x600' }}" alt="{{ $roomType->name }}">
                        <div class="room-card-body">
                            <h4 class="room-title">{{ $roomType->name }}</h4>
                            <div class="room-features">
                                <span class="room-feature"><i class="fas fa-users"></i> {{ $roomType->max_occupancy }} Guests</span>
                                <span class="room-feature"><i class="fas fa-expand-arrows-alt"></i> {{ $roomType->size_sqm }} m²</span>
                            </div>
                            <p>{{ $roomType->description }}</p>
                            <div class="price">${{ number_format($roomType->base_price, 2) }}<span>/night</span></div>
                            <a href="{{ route('frontend.rooms.show', $roomType->id) }}" class="btn-custom">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection