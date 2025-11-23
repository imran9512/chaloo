<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chaloo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .login-card { max-width: 420px; margin: 100px auto; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.3); }
        .role-btn { padding: 15px; border-radius: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card bg-white">
            <div class="text-center p-4 bg-primary text-white">
                <h1 class="mb-0">Chaloo</h1>
                <p>Vehicle Rental Marketplace</p>
            </div>

            <div class="p-4">
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                    </div>

                    <div class="mb-4">
    <label class="form-label fw-bold">Login As</label>
    <div class="row g-3">
        <div class="col-6">
            <input type="radio" name="role" value="transporter" id="transporter" class="btn-check" required>
            <label for="transporter" class="btn btn-outline-primary w-100">Transporter</label>
        </div>
        <div class="col-6">
            <input type="radio" name="role" value="agent" id="agent" class="btn-check">
            <label for="agent" class="btn btn-outline-success w-100">Agent</label>
        </div>
    </div>
</div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Login</button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('signup') }}" class="text-decoration-none">Don't have account? Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>