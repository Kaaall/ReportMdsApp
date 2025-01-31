<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekomendasi Perbaikan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-size: 12px;
            /* Slightly smaller font for PDF */
        }

        .two-column-layout {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            /* Jarak antar kolom */
            margin-top: 20px;
        }

        .column {
            width: 48%;
            /* Lebar kolom */
        }

        .column h2 {
            font-size: 20px;
            /* Ukuran font h2 lebih besar */
            font-weight: bold;
            margin-bottom: 10px;
        }

        .column ul {
            font-size: 15px;
            /* Ukuran font list */
        }

        .column li {
            margin-bottom: 5px;
            /* Jarak antar item list */
        }


        .header {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .header p {
            font-size: 14px;
            margin: 3px 0;
            color: #555;
        }

        .table-container {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 10px;
            /* Reduced font size for table */
        }

        th {
            background-color: #000000;
            color: white;
        }

        .dropdowns {
            display: flex;
            justify-content: space-between;
            margin: 10px;
        }

        .dropdowns div {
            margin: 0 5px;
            width: 30%;
            /* Reduced space between dropdowns */
        }

        select {
            padding: 6px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 10px;
            /* Smaller font for select */
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN REKOMENDASI PERBAIKAN</h1>
        <p class="table-name">{{ $namapt }}</p>
        <p class="date-info">Tanggal: {{ $tanggal }}</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">ITEM</th> <!-- Menggabungkan header ITEM -->
                    <th rowspan="2">TARGET</th> <!-- Kolom baru untuk Target -->
                    <th colspan="4">{{ strtoupper($leasing) }}</th>
                    <th rowspan="2">TOTAL</th>
                </tr>
                <tr>
                    <th>Week I (1-7)</th>
                    <th>Week II (8-14)</th>
                    <th>Week III (15-21)</th>
                    <th>Week IV (22-31)</th>
                </tr>
            </thead>
            <tbody>
                <!-- Target Incoming, menampilkan data minggu -->
                @foreach ($mergedData as $row)
                    <tr>
                        <td>Target Incoming</td> <!-- Nama jenis item -->
                        <td>{{ $row['target_incoming'] }}</td>
                        <td>{{ $row['incoming_week1'] }}</td>
                        <td>{{ $row['incoming_week2'] }}</td>
                        <td>{{ $row['incoming_week3'] }}</td>
                        <td>{{ $row['incoming_week4'] }}</td>
                        <td>{{ $row['total_incoming'] }}</td>
                    </tr>
                    <!-- Untuk item lainnya hanya tampilkan total -->
                    <tr>
                        <td>Target Booking</td>
                        <td>{{ $row['target_booking'] }}</td>
                        <td>{{ $row['booking_week1'] }}</td>
                        <td>{{ $row['booking_week2'] }}</td>
                        <td>{{ $row['booking_week3'] }}</td>
                        <td>{{ $row['booking_week4'] }}</td>
                        <td>{{ $row['total_booking'] }}</td>
                    </tr>
                    <tr>
                        <td>CMO Productivity ({{ $row['cmo'] }})</td>
                        <td>20 unit/CMO</td>
                        <td>{{ $row['cmo'] > 0 ? round($row['booking_week1'] / $row['cmo'], 0) : '-' }}</td>
                        <td>{{ $row['cmo'] > 0 ? round($row['booking_week2'] / $row['cmo'], 0) : '-' }}</td>
                        <td>{{ $row['cmo'] > 0 ? round($row['booking_week3'] / $row['cmo'], 0) : '-' }}</td>
                        <td>{{ $row['cmo'] > 0 ? round($row['booking_week4'] / $row['cmo'], 0) : '-' }}</td>
                        <td>{{ $row['cmo'] > 0 ? round($row['total_booking'] / $row['cmo'], 0) : '-' }}</td>

                    </tr>
                    <tr>
                        <td>Booking AT LPM</td>
                        <td>{{ round($row['booking_at_lpm'], 0) }}</td>
                        <td>{{ $row['booking_at_lpm_week1'] }}</td>
                        <td>{{ $row['booking_at_lpm_week2'] }}</td>
                        <td>{{ $row['booking_at_lpm_week3'] }}</td>
                        <td>{{ $row['booking_at_lpm_week4'] }}</td>
                        <td>{{ $row['total_booking_at_lpm'] }}</td>

                    </tr>
                    <tr>
                        <td>Booking AT ClASSY</td>
                        <td>{{ round($row['booking_at_classy'], 0) }}</td>
                        <td>{{ $row['booking_at_classy_week1'] }}</td>
                        <td>{{ $row['booking_at_classy_week2'] }}</td>
                        <td>{{ $row['booking_at_classy_week3'] }}</td>
                        <td>{{ $row['booking_at_classy_week4'] }}</td>
                        <td>{{ $row['total_booking_at_classy'] }}</td>
                    </tr>
                    <tr>
                        <td>Booking AT PREMIUM</td>
                        <td>{{ round($row['booking_at_premium'], 0) }}</td>
                        <td>{{ $row['booking_at_premium_week1'] }}</td>
                        <td>{{ $row['booking_at_premium_week2'] }}</td>
                        <td>{{ $row['booking_at_premium_week3'] }}</td>
                        <td>{{ $row['booking_at_premium_week4'] }}</td>
                        <td>{{ $row['total_booking_at_premium'] }}</td>

                    </tr>
                    <tr>
                        <td>YOD / FID Nov-2024</td>
                        <td>{{ $persentase }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ number_format($row['yod_fid_nov_2024'] * 100, 2) . '%' }}</td>
                    </tr>
                    <tr>
                        <td>LAP {{ $tanggal }}</td>
                        <td>Rp.{{ number_format($row['target_booking'] * 100000, 0, ',', '.') }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Rp.{{ number_format($row['target_booking'] * 100000, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="display: flex; justify-content: space-between; width: 100%;">
        <div class="column" style="flex: 1; margin-right: 20px;">
            <h2>II. Kendala dengan Leasing</h2>
            <ul>
                @foreach ($kendala as $k)
                    <li>{{ $k }}</li>
                @endforeach
            </ul>
        </div>

        <div class="column" style="flex: 1;">
            <h2>III. Perbaikan dengan Leasing</h2>
            <ul>
                @foreach ($perbaikan as $p)
                    <li>{{ $p }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <br><br><br>

    <div style="display: flex; justify-content: space-between; width: 100%;">
        <img src="data:image/jpeg;base64,{{ $foto_diskus_base64 }}"
            style="max-width: 160px; height: auto; margin-right: 360px;">
        <img src="data:image/jpeg;base64,{{ $foto_briefing_base64 }}" style="max-width: 160px; height: auto;">
    </div>

    <div style="display: flex; width: 100%;">
        <div style="flex: 1; text-align: left;">
            <p style="margin: 0;">Foto : Discussion BM MDS + Kacab Leasing</p>
        </div>

        <div style="flex: 1; text-align: right;">
            <p style="margin: 0;">Foto : Briefing Team Leasing + Team Dealer</p>
        </div>
    </div>

</body>

</html>
