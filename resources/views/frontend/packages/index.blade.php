@extends('frontend.layouts.app')

@section('title', 'Special Packages - Elisyan Suites')
@section('description', 'Explore our exclusive special packages at Elisyan Suites. Enjoy luxury accommodations with additional amenities and services.')

@section('content')
    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3') center/cover; height: 400px; display: flex; align-items: center; color: white; text-align: center;">
        <div class="container">
            <h1 class="display-3 fw-bold">Special Packages</h1>
            <p class="lead">Enjoy our exclusive packages for a memorable stay</p>
        </div>
    </section>

    <!-- Packages Section -->
    <section class="packages-section py-5">
        <div class="container">
            <div class="section-title">
                <h2>Exclusive Packages</h2>
                <p class="lead">Choose from our specially curated packages for an unforgettable experience</p>
            </div>
            <div class="row">
                @foreach($packages as $package)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="package-card">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3" alt="{{ $package->name }}">
                        </div>
                        <div class="package-body">
                            <h3>{{ $package->name }}</h3>
                            <p>{{ $package->description }}</p>
                            <div class="package-price">${{ number_format($package->price, 2) }}</div>
                            <a href="{{ route('frontend.booking.create', ['package_id' => $package->id]) }}" class="btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection