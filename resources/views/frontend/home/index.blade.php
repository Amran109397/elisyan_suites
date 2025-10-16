@extends('frontend.layouts.app')

@section('title', 'Elisyan Suites - Luxury Hotel Experience')
@section('description', 'Experience unparalleled luxury at Elisyan Suites. Book your stay in our premium hotel with world-class amenities and exceptional service.')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Welcome to Elisyan Suites</h1>
                <p>Experience unparalleled luxury and exceptional service in the heart of the city</p>
                <div class="hero-buttons">
                    <a href="{{ route('frontend.booking.create') }}" class="btn-custom">Book Your Stay</a>
                    <a href="{{ url('/rooms') }}" class="btn-custom btn-outline">View All Rooms</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Elisyan Suites</h2>
                <p class="lead">Discover what makes us the perfect choice for your stay</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4>Luxury Accommodation</h4>
                        <p>Experience world-class comfort in our elegantly designed rooms and suites with premium amenities.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h4>Exceptional Dining</h4>
                        <p>Savor exquisite cuisines prepared by our world-renowned chefs in our award-winning restaurants.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h4>Spa & Wellness</h4>
                        <p>Relax and rejuvenate your body and mind with our premium spa treatments and wellness programs.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                        <h4>Concierge Service</h4>
                        <p>Our dedicated concierge team is available 24/7 to assist you with all your needs and requests.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h4>Modern Amenities</h4>
                        <p>Stay connected with high-speed WiFi, smart TVs, and other modern conveniences in every room.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Prime Location</h4>
                        <p>Located in the heart of the city, close to major attractions, shopping, and business districts.</p>
                    </div>
                </div>
            </div>
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
                @foreach($featuredRooms as $roomType)
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
            <div class="text-center mt-4">
                <a href="{{ url('/rooms') }}" class="btn-custom btn-outline">View All Rooms</a>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section class="booking-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="booking-form">
                        <h3 class="text-center mb-4">Check Availability</h3>
                        <form action="{{ route('frontend.booking.create') }}" method="GET">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="check_in_date">Check-in Date</label>
                                        <input type="date" class="form-control" id="check_in_date" name="check_in" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="check_out_date">Check-out Date</label>
                                        <input type="date" class="form-control" id="check_out_date" name="check_out" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="adults">Adults</label>
                                        <select class="form-select" id="adults" name="adults">
                                            <option value="1">1 Adult</option>
                                            <option value="2" selected>2 Adults</option>
                                            <option value="3">3 Adults</option>
                                            <option value="4">4 Adults</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="children">Children</label>
                                        <select class="form-select" id="children" name="children">
                                            <option value="0" selected>No Children</option>
                                            <option value="1">1 Child</option>
                                            <option value="2">2 Children</option>
                                            <option value="3">3 Children</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-custom w-100">Check Availability</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-title">
                <h2>What Our Guests Say</h2>
                <p class="lead">Hear from our satisfied guests about their experience at Elisyan Suites</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>"Absolutely amazing experience! The staff was incredibly attentive and the room was luxurious. Will definitely be back!"</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah Johnson" class="author-img">
                            <div class="author-info">
                                <h5>Sarah Johnson</h5>
                                <p>Business Traveler</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>"The perfect getaway! The spa treatments were incredible and the restaurant served the best food I've had in years."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Chen" class="author-img">
                            <div class="author-info">
                                <h5>Michael Chen</h5>
                                <p>Vacationer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>"Exceptional service from start to finish. The concierge helped us plan our entire itinerary. Highly recommended!"</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Emma Williams" class="author-img">
                            <div class="author-info">
                                <h5>Emma Williams</h5>
                                <p>Honeymooner</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection