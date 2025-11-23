<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chaloo - Vehicle Rental Marketplace</title>
    
    <!-- PWA Tags (ye 4 lines zaroori hain) -->
    <link rel="manifest" href="/public/manifest.json">
    <meta name="theme-color" content="#667eea">
    <link rel="apple-touch-icon" href="/public/icons/icon-192x192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Chaloo">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; font-family: 'Segoe UI', sans-serif; }
        .hero { padding: 100px 0; color: white; }
        .btn-primary { background: #ff6b6b; border: none; padding: 12px 30px; border-radius: 50px; font-weight: bold; }
        .btn-outline-light { border-radius: 50px; padding: 12px 30px; }
        .feature-card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); text-align: center; transition: 0.3s; }
        .feature-card:hover { transform: translateY(-10px); }
        .logo { font-size: 3.5rem; font-weight: 900; color: #ff6b6b; text-shadow: 2px 2px 10px rgba(0,0,0,0.3); }
    </style>
</head>
<body>
    <div class="container hero text-center">
        <h1 class="logo mb-3">Chaloo</h1>
        <h2 class="mb-4">Pakistan's Smart Vehicle Rental Marketplace</h2>
        <p class="lead mb-5">Rent cars, hiaces, coasters with driver — anywhere in Pakistan</p>

        <div class="mb-5">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">Login</a>
            <a href="{{ route('signup') }}" class="btn btn-outline-light btn-lg">Sign Up Free</a>
        </div>

        <div class="row mt-5">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <h4>For Transporters</h4>
                    <p>List your vehicles & get direct bookings</p>
                    <a href="/login?role=transporter" class="btn btn-outline-primary mt-3">Transporter Login</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <h4>For Agents</h4>
                    <p>Find vehicles instantly for your clients</p>
                    <a href="/login?role=agent" class="btn btn-outline-success mt-3">Agent Login</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <h4>Admin Panel</h4>
                    <p>Full control & monitoring</p>
                    <a href="/admin/login" class="btn btn-outline-dark mt-3">Admin Login</a>
                </div>
            </div>
        </div>

        <footer class="text-center mt-5 text-white-50">
            © 2025 Chaloo.pk — Made with ❤️ in Pakistan
        </footer>
    </div>
</body>
</html>