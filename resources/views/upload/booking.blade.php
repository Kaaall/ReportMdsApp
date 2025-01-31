@extends('layouts.admin')

@section('title', 'Upload Booking')

@section('content')
    <div class="container">
        <h1 class="mb-4">Upload Data Booking</h1>
        @if (session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
        @if (session('error'))
            <p class="alert alert-danger">{{ session('error') }}</p>
        @endif

        <form action="{{ route('import.booking') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Pilih File Excel</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <br>

        <h2>Data Booking</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Model Name</th>
                    <th>Leasing</th>
                    <th>Request Date</th>
                    <th>Req Dealer</th>
                    <th>Category</th>
                    <th>Period</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($booking as $dataBooking)
                    <tr>
                        <td>{{ $dataBooking->model_name ?? 'N/A' }}</td>
                        <td>{{ $dataBooking->leasing ?? 'N/A' }}</td>
                        <td>{{ $dataBooking->request_date ?? 'N/A' }}</td>
                        <td>{{ $dataBooking->req_dealer ?? 'N/A' }}</td>
                        <td>{{ $dataBooking->category ?? 'N/A' }}</td>
                        <td>{{ $dataBooking->period ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $booking->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
