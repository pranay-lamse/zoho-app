<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Import</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e1e2f;
            color: #fff;
        }

        .card {
            background-color: #2a2a3b;
            border-radius: 10px;
            border: 1px solid #3a3a4e;
            padding: 25px;
            margin-top: 80px;
        }

        .btn-upload,
        .btn-sample {
            background-color: #4a5cff;
            color: #fff;
            border-radius: 6px;
        }

        .btn-upload:hover,
        .btn-sample:hover {
            background-color: #394aff;
        }

        input[type="file"] {
            background-color: #2a2a3b;
            color: #fff;
            border: 1px solid #3a3a4e;
            padding: 10px;
            width: 100%;
        }

        .alert {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-6">

                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif

                <div class="card shadow">
                    <h3 class="mb-4 text-white">📁 Import CSV File</h3>

                    <a href="{{ route('sample.csv') }}" class="btn btn-sample w-100 mb-3">📥 Download Sample CSV</a>

                    <form action="{{ route('import.csv') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" required>
                        <button type="submit" class="btn btn-upload mt-3 w-100">Upload Now 🚀</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
