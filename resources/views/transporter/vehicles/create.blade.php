<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle - Chaloo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .form-card { max-width: 800px; margin: 50px auto; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.3); }
    </style>
</head>
<body>
<div class="container">
    <div class="form-card bg-white">
        <div class="bg-primary text-white p-4 text-center">
            <h2>Add New Vehicle</h2>
        </div>
        <div class="p-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('transporter.vehicles.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Vehicle Name</label>
                        <input type="text" name="name" class="form-control form-control-lg" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Vehicle Type</label>
                        <select name="vehicle_type_id" class="form-select form-select-lg" required>
                            <option value="">Select Type</option>
                            @foreach(\App\Models\VehicleType::all() as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">City</label>
                        <input type="text" name="city" class="form-control form-control-lg" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Seats</label>
                        <input type="number" name="seats" class="form-control form-control-lg" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Base Rate (per day)</label>
                        <input type="number" name="base_rate" class="form-control form-control-lg" required>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Driver Charges (per day) <small class="text-muted">(optional)</small></label>
                        <input type="number" name="driver_rate" class="form-control form-control-lg" placeholder="e.g. 2000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Special Note <small class="text-muted">(optional)</small></label>
                        <textarea name="special_note" class="form-control" rows="3" placeholder="e.g. Full AC, WiFi, Recliner Seats"></textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="form-label fw-bold">Vehicle Photos (multiple)</label>
                    <input type="file" name="photos[]" multiple accept="image/*" class="form-control form-control-lg" required>
                    <small class="text-muted">First photo will be primary • Max 20MB each</small>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-success btn-lg px-5">Add Vehicle</button>
                    <a href="{{ route('transporter.dashboard') }}" class="btn btn-secondary btn-lg px-5 ms-3">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>