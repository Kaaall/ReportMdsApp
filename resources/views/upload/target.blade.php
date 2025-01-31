@extends('layouts.admin')

@section('title', 'Target Leasing')

@section('content')
    <div class="header text-center bg-dark text-white py-3 rounded">
        <h2>Data Target Leasing</h2>
    </div>

    <!-- Filter Tabel -->
    <div class="button-group text-center my-4">
        <form action="{{ route('index.target') }}" method="GET" class="d-inline">
            @foreach (['adira', 'baf', 'imfi', 'maf', 'oto', 'mmf', 'wom'] as $type)
                <button type="submit" name="table_type" value="{{ $type }}"
                    class="btn btn-secondary mx-2 {{ $tableType == $type ? 'disabled' : '' }}">
                    {{ strtoupper($type) }}
                </button>
            @endforeach
        </form>
    </div>

    <!-- Upload Excel -->
    <div class="card my-4">
        <div class="card-body">
            <h5 class="card-title">Upload File Excel</h5>
            <form action="{{ route('upload.target') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="table_type" value="{{ $tableType }}">
                <div class="mb-3">
                    <label for="excel" class="form-label">Pilih File Excel:</label>
                    <input type="file" name="excel" id="excel" class="form-control" accept=".xlsx,.xls" required>
                </div>
                <button type="submit" class="btn btn-success">Upload</button>
            </form>
        </div>
    </div>
    <!-- Tabel Data -->
    <div class="table-responsive my-4">
        <table class="table table-bordered table-striped">
            <thead class="bg-success text-white">
                <tr>
                    <th>Kode Dealer</th>
                    <th>Dealer</th>
                    <th>Leasing</th>
                    <th>Target Incoming</th>
                    <th>Target Booking</th>
                    <th>CMO Productivity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tableData as $row)
                    <tr>
                        <td>{{ is_array($row->kode_dealer) ? implode(', ', $row->kode_dealer) : $row->kode_dealer ?? '-' }}
                        </td>
                        <td>{{ is_array($row->dealer) ? implode(', ', $row->dealer) : $row->dealer ?? '-' }}</td>
                        <td>{{ is_array($row->leasing) ? implode(', ', $row->leasing) : $row->leasing ?? '-' }}</td>
                        <td>{{ is_array($row->target_incoming) ? implode(', ', $row->target_incoming) : $row->target_incoming ?? '-' }}
                        </td>
                        <td>{{ is_array($row->target_booking) ? implode(', ', $row->target_booking) : $row->target_booking ?? '-' }}
                        </td>
                        <td>{{ is_array($row->cmo) ? implode(', ', $row->cmo) : $row->cmo ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
