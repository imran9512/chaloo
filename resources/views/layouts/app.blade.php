<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Chaloo')</title>
    
    <!-- PWA Tags -->
    <link rel="manifest" href="/public/manifest.json">
    <meta name="theme-color" content="#667eea">
    <link rel="apple-touch-icon" href="/public/icons/icon-192x192.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
</head>
<body>
    @yield('content')

    <script>
        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/public/service-worker.js')
                    .then(reg => console.log('SW registered'))
                    .catch(err => console.log('SW failed', err));
            });
        }
    </script>
    @yield('scripts')
</body>
</html>