@extends('layouts.user')

@section('title', 'Laporan Rekomendasi Perbaikan')

@section('content')
    <div class="container my-4">
        <div class="text-center mb-4">
            <h1 class="display-6">LAPORAN REKOMENDASI PERBAIKAN</h1>
            <p class="fw-bold">{{ $namapt }}</p>
            <p class="text-muted">Tanggal: {{ $tanggal }}</p>
        </div>

        <form method="GET" action="{{ route('surat') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="table_type" class="form-label">Leasing</label>
                <select name="table_type" id="table_type" class="form-select">
                    <option value="adira" {{ request('table_type') == 'adira' ? 'selected' : '' }}>ADIRA</option>
                    <option value="baf" {{ request('table_type') == 'baf' ? 'selected' : '' }}>BAF</option>
                    <option value="imfi" {{ request('table_type') == 'imfi' ? 'selected' : '' }}>IMFI</option>
                    <option value="maf" {{ request('table_type') == 'maf' ? 'selected' : '' }}>MAF</option>
                    <option value="mmf" {{ request('table_type') == 'mmf' ? 'selected' : '' }}>MMF</option>
                    <option value="wom" {{ request('table_type') == 'wom' ? 'selected' : '' }}>WOM</option>
                    <option value="oto" {{ request('table_type') == 'oto' ? 'selected' : '' }}>OTO</option>
                </select>
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="2" style="text-align: center;">ITEM</th> <!-- Menggabungkan header ITEM -->
                        <th rowspan="2" style="text-align: center;">Target</th> <!-- Kolom baru untuk Target -->
                        <th colspan="4" style="text-align: center;">{{ strtoupper($leasing) }}</th>
                        <th rowspan="2" style="text-align: center;">TOTAL</th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">Week I (1-7)</th>
                        <th style="text-align: center;">Week II (8-14)</th>
                        <th style="text-align: center;">Week III (15-21)</th>
                        <th style="text-align: center;">Week IV (22-31)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Target Incoming, menampilkan data minggu -->
                    @foreach ($mergedData as $row)
                        <tr>
                            <td style="text-align: center;">Target Incoming</td> <!-- Nama jenis item -->
                            <td style="text-align: center;">{{ $row['target_incoming'] }}</td>
                            <td style="text-align: center;">{{ $row['incoming_week1'] }}</td>
                            <td style="text-align: center;">{{ $row['incoming_week2'] }}</td>
                            <td style="text-align: center;">{{ $row['incoming_week3'] }}</td>
                            <td style="text-align: center;">{{ $row['incoming_week4'] }}</td>
                            <td style="text-align: center;">{{ $row['total_incoming'] }}</td>
                        </tr>
                        <!-- Untuk item lainnya hanya tampilkan total -->
                        <tr>
                        <tr>
                            <td style="text-align: center;">Target Booking</td>
                            <td style="text-align: center;">{{ $row['target_booking'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_week1'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_week2'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_week3'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_week4'] }}</td>
                            <td style="text-align: center;">{{ $row['total_booking'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">CMO Productivity ({{ $row['cmo'] }})</td>
                            <td style="text-align: center;">20 unit/CMO</td>
                            <td style="text-align: center;">
                                {{ $row['cmo'] > 0 ? round($row['booking_week1'] / $row['cmo'], 0) : '-' }}</td>
                            <td style="text-align: center;">
                                {{ $row['cmo'] > 0 ? round($row['booking_week2'] / $row['cmo'], 0) : '-' }}</td>
                            <td style="text-align: center;">
                                {{ $row['cmo'] > 0 ? round($row['booking_week3'] / $row['cmo'], 0) : '-' }}</td>
                            <td style="text-align: center;">
                                {{ $row['cmo'] > 0 ? round($row['booking_week4'] / $row['cmo'], 0) : '-' }}</td>
                            <td style="text-align: center;">
                                {{ $row['cmo'] > 0 ? round($row['total_booking'] / $row['cmo'], 0) : '-' }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Booking AT LPM</td>
                            <td style="text-align: center;">{{ round($row['booking_at_lpm'], 0) }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_lpm_week1'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_lpm_week2'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_lpm_week3'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_lpm_week4'] }}</td>
                            <td style="text-align: center;">{{ $row['total_booking_at_lpm'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Booking AT Classy</td>
                            <td style="text-align: center;">{{ round($row['booking_at_classy'], 0) }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_classy_week1'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_classy_week2'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_classy_week3'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_classy_week4'] }}</td>
                            <td style="text-align: center;">{{ $row['total_booking_at_classy'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Booking AT Premium</td>
                            <td style="text-align: center;">{{ round($row['booking_at_premium'], 0) }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_premium_week1'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_premium_week2'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_premium_week3'] }}</td>
                            <td style="text-align: center;">{{ $row['booking_at_premium_week4'] }}</td>
                            <td style="text-align: center;">{{ $row['total_booking_at_premium'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">YOD / FID Nov-2024</td>
                            <td style="text-align: center;">{{ $persentase }}</td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;">
                                {{ number_format($row['yod_fid_nov_2024'] * 100, 2) . '%' }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">LAP {{ $tanggal }}</td>
                            <td style="text-align: center;">
                                Rp.{{ number_format($row['target_booking'] * 100000, 0, ',', '.') }}</td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;">
                                Rp.-{{ number_format($row['target_booking'] * 100000, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <form action="{{ route('exportPdf') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="dealer" value="{{ request('dealer') }}">
            <input type="hidden" name="table_type" value="{{ request('table_type') }}">

            <div class="row g-3">
                <div class="col-md-6">
                    <h5>II. Kendala dengan Leasing</h5>
                    @for ($i = 1; $i <= 3; $i++)
                        <textarea name="kendala[]" class="form-control mb-2" rows="3"
                            placeholder="Masukkan Kendala {{ $i }}..."></textarea>
                    @endfor
                </div>
                <div class="col-md-6">
                    <h5>III. Perbaikan dengan Leasing</h5>
                    @for ($i = 1; $i <= 3; $i++)
                        <textarea name="perbaikan[]" class="form-control mb-2" rows="3"
                            placeholder="Masukkan Perbaikan {{ $i }}..."></textarea>
                    @endfor
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label for="foto_diskus" class="form-label">Pilih Foto Discussion BM MDS + Kacab Leasing:</label>
                    <input type="file" id="foto_diskus" name="foto_diskus" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="foto_briefing" class="form-label">Pilih Foto Briefing Team Leasing + Team Dealer:</label>
                    <input type="file" id="foto_briefing" name="foto_briefing" class="form-control">
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success">Generate PDF</button>
            </div>
        </form>
    </div>
@endsection
