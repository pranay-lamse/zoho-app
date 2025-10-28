@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #f1f3f5 !important;
        }

        .filter-box {
            background: #ffffff;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #ddd;
        }

        .filter-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .table-custom thead {
            background: #0d6efd;
            color: #fff;
        }

        .table-custom tbody tr:hover {
            background: #f5f9ff;
        }

        .card-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #ddd;
        }
    </style>

    <div class="container mt-4">
        <div class="card-container shadow-sm">

            <h3 class="mb-4 text-primary">Imported Users List</h3>

            <!-- Filter Form -->
            <div class="filter-box mb-4">
                <div class="filter-title">Filter Users</div>
                <form method="GET" action="{{ route('users.index') }}" class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <select name="city" class="form-select">
                            <option value="">All Cities</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}"
                                    {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-50">Apply</button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary w-50">Reset</a>
                    </div>

                </form>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-custom table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Category</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name ?? '-' }}</td>
                                <td>{{ $user->email ?? 'Null' }}</td>
                                <td>{{ $user->city ?? 'Null' }}</td>
                                <td>{{ $user->state ?? 'Null' }}</td>
                                <td>{{ $user->category ?? 'Null' }}</td>
                            </tr>
                        @empty
                            <tr class="text-center text-danger">
                                <td colspan="5">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $users->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
@endsection
