<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Chaloo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .login-box {
            max-width: 420px;
            margin: 100px auto;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            background: #667eea;
            border: none;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <div class="card p-4">
            <div class="text-center mb-4">
                <div class="logo mb-3">Chaloo</div>
                <h4>Admin Login</h4>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(request()->url()); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email"
                        value="admin@chaloo.com" required autofocus>
                </div>
                <div class="mb-3 input-group">
                    <input type="password" name="password" id="password" class="form-control form-control-lg"
                        placeholder="Password" value="11223344" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        👁️
                    </button>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    Login as Admin
                </button>
            </form>

            <div class="text-center mt-3 text-muted">
                <small>Super Admin: LOGIN HERE ONLY</small>
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
            // toggle the eye icon
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>
</body>

</html><?php /**PATH D:\laragon\www\Chaloo\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>