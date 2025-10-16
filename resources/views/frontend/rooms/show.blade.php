@extends('frontend.layouts.app')

@section('title', $roomType->name . ' - Elisyan Suites')
@section('description', 'Experience our luxurious ' . $roomType->name . ' at Elisyan Suites with modern amenities, stunning city views, and exceptional comfort.')

@section('content')
    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ $roomType->roomImages->first()->image_path ?? 'https://via.placeholder.com/1200x400' }}') center/cover; height: 400px; display: flex; align-items: center; color: white; text-align: center;">
        <div class="container">
            <h1 class="display-3 fw-bold">{{ $roomType->name }}</h1>
            <p class="lead">{{ $roomType->description }}</p>
        </div>
    </section>

    <!-- Room Details Section -->
    <section class="room-details-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Room Images -->
                    <div class="room-images mb-4">
                        <div id="roomImageCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($roomType->roomImages as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ $image->image_path }}" class="d-block w-100" alt="{{ $roomType->name }}">
                                </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#roomImageCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#roomImageCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <!-- Room Description -->
                    <div class="room-description mb-4">
                        <h3>Room Description</h3>
                        <p>{{ $roomType->description }}</p>
                    </div>

                    <!-- Room Amenities -->
                    <div class="room-amenities mb-4">
                        <h3>Room Amenities</h3>
                        <div class="row">
                            @foreach($roomType->amenities as $amenity)
                            <div class="col-md-6 mb-2">
                                <i class="{{ $amenity->icon }}"></i> {{ $amenity->name }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Booking Form -->
                    <div class="booking-form-card">
                        <div class="price">${{ number_format($roomType->base_price, 2) }}<span>/night</span></div>
                        <form action="{{ route('frontend.booking.create') }}" method="GET">
                            <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
                            <div class="form-group mb-3">
                                <label for="check_in_date">Check-in Date</label>
                                <input type="date" class="form-control" id="check_in_date" name="check_in" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="check_out_date">Check-out Date</label>
                                <input type="date" class="form-control" id="check_out_date" name="check_out" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="adults">Adults</label>
                                <select class="form-select" id="adults" name="adults">
                                    <option value="1">1 Adult</option>
                                    <option value="2" selected>2 Adults</option>
                                    <option value="3">3 Adults</option>
                                    <option value="4">4 Adults</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="children">Children</label>
                                <select class="form-select" id="children" name="children">
                                    <option value="0" selected>No Children</option>
                                    <option value="1">1 Child</option>
                                    <option value="2">2 Children</option>
                                    <option value="3">3 Children</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-custom w-100">Book Now</button>
                        </form>
                    </div>

                    <!-- Room Features -->
                    <div class="room-features-card">
                        <h3>Room Features</h3>
                        <ul>
                            <li><i class="fas fa-users"></i> Max Occupancy: {{ $roomType->max_occupancy }} Guests</li>
                            <li><i class="fas fa-expand-arrows-alt"></i> Size: {{ $roomType->size_sqm }} m²</li>
                            <li><i class="fas fa-bed"></i> Bed Type: {{ $roomType->bed_type }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Rooms Section -->
    <section class="related-rooms-section py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>Related Rooms</h2>
                <p class="lead">You might also be interested in these rooms</p>
            </div>
            <div class="row">
                @foreach($relatedRooms as $room)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="room-card">
                        <img src="{{ $room->roomImages->first()->image_path ?? 'https://via.placeholder.com/800x600' }}" alt="{{ $room->name }}">
                        <div class="room-card-body">
                            <h4 class="room-title">{{ $room->name }}</h4>
                            <div class="room-features">
                                <span class="room-feature"><i class="fas fa-users"></i> {{ $room->max_occupancy }} Guests</span>
                                <span class="room-feature"><i class="fas fa-expand-arrows-alt"></i> {{ $room->size_sqm }} m²</span>
                            </div>
                            <p>{{ $room->description }}</p>
                            <div class="price">${{ number_format($room->base_price, 2) }}<span>/night</span></div>
                            <a href="{{ route('frontend.rooms.show', $room->id) }}" class="btn-custom">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection