<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Chaloo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand">Chaloo Admin</span>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success text-center">
                    <h2>Login Successful!</h2>
                    <p>Welcome <strong>{{ auth('admin')->user()->name }}</strong> ({{ auth('admin')->user()->role }})</p>
                    <hr>
                    <h4>Chaloo Admin Panel Ready!</h4>
                </div>
            </div>
        </div>
    </div>
</body>
</html>