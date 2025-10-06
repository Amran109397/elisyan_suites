<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    
    @stack('styles')
</head>

<body>
    <div class="app-container">
        <!-- Fixed Sidebar -->
        @include('backend.partials.sidebar')

        <!-- Main Content Area -->
        <div class="main-content" id="mainContent">
            <!-- Top Navigation -->
            @include('backend.partials.topnav')

            <!-- Dashboard Content -->
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html>