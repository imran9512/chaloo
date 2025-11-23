<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Chaloo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .login-box { max-width: 420px; margin: 100px auto; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .btn-primary { background: #667eea; border: none; }
        .logo { font-size: 2.5rem; font-weight: bold; color: #667eea; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="card p-4">
            <div class="text-center mb-4">
                <div class="logo mb-3">Chaloo</div>
                <h4>Admin Login</h4>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-3">
                    <input type="email" name="email" class="form-control form-control-lg" 
                           placeholder="Email" value="admin@chaloo.com" required autofocus>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control form-control-lg" 
                           placeholder="Password" value="admin123" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    Login as Admin
                </button>
            </form>

            <div class="text-center mt-3 text-muted">
                <small>Super Admin: admin@chaloo.com / admin123</small>
            </div>
        </div>
    </div>
</body>
</html>