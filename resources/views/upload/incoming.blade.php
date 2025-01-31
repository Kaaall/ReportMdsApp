@extends('layouts.admin')

@section('title', 'Data Incoming')

@section('content')
    <div class="container">
        <h1 class="mb-4">Data Incoming</h1>
        <form action="{{ route('incoming.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Import Excel File</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Import Excel</button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Dealer</th>
                        <th>Tanggal Order</th>
                        <th>Nama Pemohon</th>
                        <th>Leasing</th>
                        <th>OTR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incoming as $report)
                        <tr>
                            <td>{{ $report->kode_dealer }}</td>
                            <td>{{ $report->tgl_order }}</td>
                            <td>{{ $report->nama_pemohon }}</td>
                            <td>{{ $report->leasing }}</td>
                            <td>{{ number_format($report->otr, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $incoming->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
