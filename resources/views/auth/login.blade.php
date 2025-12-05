<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chaloo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .login-card {
            max-width: 420px;
            margin: 100px auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .role-btn {
            padding: 15px;
            border-radius: 12px;
            font-weight: bold;
        }
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
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // toggle the eye icon (optional, could be improved with icon swap)
            this.classList.toggle('active');
        });
    </script>
</body>

</html>