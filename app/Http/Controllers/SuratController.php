<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tgtadira;
use App\Models\Tgtbaf;
use App\Models\Tgtimfi;
use App\Models\Tgtmaf;
use App\Models\Tgtmmf;
use App\Models\Tgtoto;
use App\Models\Tgtwom;
use App\Models\DataBooking;
use App\Models\DataIncoming;
use App\Models\Dealer;
use App\Exports\SuratExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class SuratController extends Controller
{
    public function index(Request $request)
    {
        $kodeDealer = Auth::user()->kode_dealer;
        $role = Auth::user()->role;  // Ambil role pengguna yang sedang login

        // Mengambil dealer yang dipilih pada filter, jika ada
        $dealerFilter = $request->input('dealer', null);  // Filter dealer yang dipilih dari form

        // Jika pengguna adalah master, tampilkan semua dealer
        // Mengambil dealer yang dipilih pada filter, jika ada
        $dealerFilter = $request->input('dealer', null);  // Filter dealer yang dipilih dari form

        // Jika pengguna adalah master, tampilkan semua dealer
        if ($role === 'master') {
            $dealers = Tgtadira::distinct()->pluck('dealer', 'kode_dealer');

            // Ambil nama dealer berdasarkan kode dealer yang dipilih dari filter atau kode dealer master
            $kodeDealer = $dealerFilter ?: $kodeDealer;
        } else {
            // Jika pengguna adalah user biasa, hanya tampilkan dealer sesuai kode_dealer pengguna
            $dealers = Tgtadira::where('kode_dealer', $kodeDealer)->distinct()->pluck('dealer', 'kode_dealer');
        }


        $leasing = $request->input('table_type', null);

        $dealer = Dealer::findByKodeDealer($kodeDealer);
        $namaDealer = $dealer ? $dealer->nama_dealer : 'Dealer Tidak Ditemukan';

        // Ambil data dealer untuk target dan incoming berdasarkan kode_dealer yang dipilih
        $dealerData = Tgtadira::where('kode_dealer', $kodeDealer)->first();
        $namapt = $dealerData ? $dealerData->dealer : '';

        $persentase = ($leasing === 'baf') ? '10%' : '4%';

        // Fetch booking data (with or without leasing and dealer restriction)
        $tanggalDataBooking = DataBooking::query()
            ->when($dealerFilter, fn($query) => $query->where('req_dealer', strtoupper($dealerFilter)))  // Apply the dealer filter if selected
            ->when($leasing, fn($query) => $query->where('leasing', strtoupper($leasing)))
            ->orderBy('request_date', 'desc')
            ->first();

        $tanggal = $tanggalDataBooking && $tanggalDataBooking->request_date
            ? \Carbon\Carbon::parse($tanggalDataBooking->request_date)->format('d M')
            : now()->format('d M');

        // Fetch and merge target data
        $dataTarget = $this->getTargetData($dealerFilter ?? $kodeDealer, $leasing);
        $dataIncoming = $this->getIncomingData($dealerFilter ?? $kodeDealer, $leasing);
        $dataBooking = $this->getBookingData($dealerFilter ?? $kodeDealer, $leasing);


        $mergedData = $dataTarget->map(function ($item) use ($dataIncoming, $dataBooking) {
            $relatedIncoming = $dataIncoming->firstWhere(fn($data) => $this->isMatchingDealerAndLeasing($data, $item));
            $relatedBooking = $dataBooking->where(fn($data) => $this->isMatchingDealerAndLeasing($data, $item));


            $bookingAtLPM = $this->calculateCategoryBooking($relatedBooking, 'AT LPM');
            $bookingAtClassy = $this->calculateCategoryBooking($relatedBooking, 'AT CLASSY');
            $bookingAtPremium = $this->calculateCategoryBooking($relatedBooking, 'AT PREMIUM');

            $cmo = $this->getCmoValue($item);

            $totalBooking = $relatedBooking->sum(fn($data) => ($data->week1 ?? 0) + ($data->week2 ?? 0) + ($data->week3 ?? 0) + ($data->week4 ?? 0));

            $cmoProductivity = $cmo > 0 ? round($totalBooking / $cmo, 2) : 0;

            return [
                'nama_dealer' => Dealer::getNamaDealerByKode($item->kode_dealer),
                'leasing' => $item->leasing,
                'target_incoming' => $item->target_incoming,
                'target_booking' => $item->target_booking,
                'booking_at_lpm' => $item->booking_at_lpm,
                'booking_at_classy' => $item->booking_at_classy,
                'booking_at_premium' => $item->booking_at_premium,
                'yod_fid_nov_2024' => $item->yod_fid_nov_2024,
                'booking_week1' => $relatedBooking->sum(fn($data) => $data->week1 ?? 0),
                'booking_week2' => $relatedBooking->sum(fn($data) => $data->week2 ?? 0),
                'booking_week3' => $relatedBooking->sum(fn($data) => $data->week3 ?? 0),
                'booking_week4' => $relatedBooking->sum(fn($data) => $data->week4 ?? 0),
                'booking_at_lpm_week1' => $bookingAtLPM['week1'],
                'booking_at_lpm_week2' => $bookingAtLPM['week2'],
                'booking_at_lpm_week3' => $bookingAtLPM['week3'],
                'booking_at_lpm_week4' => $bookingAtLPM['week4'],
                'total_booking_at_lpm' => $bookingAtLPM['total'],
                'booking_at_classy_week1' => $bookingAtClassy['week1'],
                'booking_at_classy_week2' => $bookingAtClassy['week2'],
                'booking_at_classy_week3' => $bookingAtClassy['week3'],
                'booking_at_classy_week4' => $bookingAtClassy['week4'],
                'total_booking_at_classy' => $bookingAtClassy['total'],
                'booking_at_premium_week1' => $bookingAtPremium['week1'],
                'booking_at_premium_week2' => $bookingAtPremium['week2'],
                'booking_at_premium_week3' => $bookingAtPremium['week3'],
                'booking_at_premium_week4' => $bookingAtPremium['week4'],
                'total_booking_at_premium' => $bookingAtPremium['total'],
                'cmo' => $cmo,
                'cmo_productivity' => $cmoProductivity,
                'incoming_week1' => $relatedIncoming->week1 ?? 0,
                'incoming_week2' => $relatedIncoming->week2 ?? 0,
                'incoming_week3' => $relatedIncoming->week3 ?? 0,
                'incoming_week4' => $relatedIncoming->week4 ?? 0,
                'total_incoming' => $this->calculateTotalIncoming($relatedIncoming),
                'total_booking' => $totalBooking,
            ];
        });

        // Pilih view berdasarkan role
        if ($role === 'master') {
            return view('laporan.suratAsli', [
                'persentase' => $persentase,
                'mergedData' => $mergedData,
                'kodeDealer' => $kodeDealer,
                'leasing' => $leasing,
                'dealers' => $dealers,  // Dealers yang diambil berdasarkan role
                'tanggal' => $tanggal,
                'namapt' => $namapt,
                'namaDealer' => $namaDealer,
            ]);
        } else {
            return view('laporan.user.surat', [
                'persentase' => $persentase,
                'mergedData' => $mergedData,
                'kodeDealer' => $kodeDealer,
                'leasing' => $leasing,
                'dealers' => $dealers,  // Dealers yang diambil berdasarkan role
                'tanggal' => $tanggal,
                'namapt' => $namapt,
                'namaDealer' => $namaDealer,
            ]);
        }
    }


    private function getTargetData($kodeDealer, $leasing)
    {
        $query = Tgtadira::query();
        if ($kodeDealer) $query->where('kode_dealer', strtoupper($kodeDealer));
        if ($leasing) $query->where('leasing', strtoupper($leasing));

        return $query->get()
            ->merge(Tgtbaf::where('kode_dealer', strtoupper($kodeDealer))->where('leasing', strtoupper($leasing))->get())
            ->merge(Tgtimfi::where('kode_dealer', strtoupper($kodeDealer))->where('leasing', strtoupper($leasing))->get())
            ->merge(Tgtmaf::where('kode_dealer', strtoupper($kodeDealer))->where('leasing', strtoupper($leasing))->get())
            ->merge(Tgtwom::where('kode_dealer', strtoupper($kodeDealer))->where('leasing', strtoupper($leasing))->get())
            ->merge(Tgtoto::where('kode_dealer', strtoupper($kodeDealer))->where('leasing', strtoupper($leasing))->get())
            ->merge(Tgtmmf::where('kode_dealer', strtoupper($kodeDealer))->where('leasing', strtoupper($leasing))->get());
    }

    private function getIncomingData($kodeDealer, $leasing)
    {
        return DataIncoming::query()
            ->when($kodeDealer, fn($query) => $query->where('kode_dealer', strtoupper($kodeDealer)))
            ->when($leasing, fn($query) => $query->where('leasing', strtoupper($leasing)))
            ->whereBetween('tgl_order', ['2024-12-01', '2024-12-31'])
            ->select(
                'kode_dealer',
                'leasing',
                DB::raw("SUM(CASE WHEN DAY(tgl_order) BETWEEN 1 AND 7 THEN 1 ELSE 0 END) as week1"),
                DB::raw("SUM(CASE WHEN DAY(tgl_order) BETWEEN 8 AND 14 THEN 1 ELSE 0 END) as week2"),
                DB::raw("SUM(CASE WHEN DAY(tgl_order) BETWEEN 15 AND 21 THEN 1 ELSE 0 END) as week3"),
                DB::raw("SUM(CASE WHEN DAY(tgl_order) BETWEEN 22 AND 31 THEN 1 ELSE 0 END) as week4")
            )
            ->groupBy('kode_dealer', 'leasing')
            ->get();
    }

    private function getBookingData($kodeDealer, $leasing)
    {
        return DataBooking::query()
            ->when($kodeDealer, fn($query) => $query->where('req_dealer', strtoupper($kodeDealer)))
            ->when($leasing, fn($query) => $query->where('leasing', strtoupper($leasing)))
            ->whereBetween('request_date', ['2024-12-01', '2024-12-31'])
            ->select(
                'req_dealer as kode_dealer',
                'leasing',
                'category',
                DB::raw("SUM(CASE WHEN DAY(request_date) BETWEEN 1 AND 7 THEN 1 ELSE 0 END) as week1"),
                DB::raw("SUM(CASE WHEN DAY(request_date) BETWEEN 8 AND 14 THEN 1 ELSE 0 END) as week2"),
                DB::raw("SUM(CASE WHEN DAY(request_date) BETWEEN 15 AND 21 THEN 1 ELSE 0 END) as week3"),
                DB::raw("SUM(CASE WHEN DAY(request_date) BETWEEN 22 AND 31 THEN 1 ELSE 0 END) as week4")
            )
            ->groupBy('kode_dealer', 'leasing', 'category')
            ->get();
    }

    private function isMatchingDealerAndLeasing($data, $item)
    {
        return strtoupper($data->kode_dealer) === strtoupper($item->kode_dealer) &&
            strtoupper($data->leasing) === strtoupper($item->leasing);
    }

    private function calculateCategoryBooking($relatedBooking, $category)
    {
        return collect(['week1', 'week2', 'week3', 'week4'])->mapWithKeys(function ($week) use ($relatedBooking, $category) {
            return [$week => $relatedBooking->where('category', $category)->sum(fn($data) => $data->{$week} ?? 0)];
        })->merge(['total' => $this->calculateCategoryTotal($relatedBooking, $category)]);
    }

    private function calculateCategoryTotal($relatedBooking, $category)
    {
        return collect(['week1', 'week2', 'week3', 'week4'])->sum(fn($week) => $relatedBooking->where('category', $category)->sum(fn($data) => $data->{$week} ?? 0));
    }

    private function calculateTotalIncoming($relatedIncoming)
    {
        return collect(['week1', 'week2', 'week3', 'week4'])->sum(fn($week) => $relatedIncoming->{$week} ?? 0);
    }

    private function getCmoValue($item)
    {
        $model = match (strtoupper($item->leasing)) {
            'BAF' => Tgtbaf::class,
            'IMFI' => Tgtimfi::class,
            'MAF' => Tgtmaf::class,
            'MMF' => Tgtmmf::class,
            'WOM' => Tgtwom::class,
            'OTO' => Tgtoto::class,
            default => Tgtadira::class,
        };

        return $model::where('kode_dealer', $item->kode_dealer)->value('cmo');
    }

    public function exportPdf(Request $request)
    {
        $kodeDealer = Auth::user()->kode_dealer;

        $kodeDealerRequest = $request->post('dealer', $kodeDealer);
        $leasing = $request->post('table_type');
        $kendala = $request->post('kendala');
        $perbaikan = $request->post('perbaikan');
        $foto_diskus = $request->file('foto_diskus');
        $foto_briefing = $request->file('foto_briefing');
        $foto_diskus_base64 = base64_encode(file_get_contents($foto_diskus));
        $foto_briefing_base64 = base64_encode(file_get_contents($foto_briefing));

        $persentase = ($leasing === 'baf') ? '10%' : '4%';

        $dealer = Dealer::findByKodeDealer($kodeDealerRequest);
        $namaDealer = $dealer ? $dealer->nama_dealer : 'Dealer Tidak Ditemukan';

        $dealerData = Tgtadira::where('kode_dealer', $kodeDealerRequest)->first();
        $namapt = $dealerData ? $dealerData->dealer : '';

        $tanggalDataBooking = DataBooking::query()
            ->when($kodeDealerRequest, fn($query) => $query->where('req_dealer', strtoupper($kodeDealerRequest)))
            ->when($leasing, fn($query) => $query->where('leasing', strtoupper($leasing)))
            ->orderBy('request_date', 'desc')
            ->first();

        $tanggal = $tanggalDataBooking && $tanggalDataBooking->request_date
            ? \Carbon\Carbon::parse($tanggalDataBooking->request_date)->format('d M')
            : now()->format('d M');

        $dataTarget = $this->getTargetData($kodeDealerRequest, $leasing);
        $dataIncoming = $this->getIncomingData($kodeDealerRequest, $leasing);
        $dataBooking = $this->getBookingData($kodeDealerRequest, $leasing);

        $mergedData = $dataTarget->map(function ($item) use ($dataIncoming, $dataBooking) {
            $relatedIncoming = $dataIncoming->firstWhere(fn($data) => $this->isMatchingDealerAndLeasing($data, $item));
            $relatedBooking = $dataBooking->where(fn($data) => $this->isMatchingDealerAndLeasing($data, $item));

            $bookingAtLPM = $this->calculateCategoryBooking($relatedBooking, 'AT LPM');
            $bookingAtClassy = $this->calculateCategoryBooking($relatedBooking, 'AT CLASSY');
            $bookingAtPremium = $this->calculateCategoryBooking($relatedBooking, 'AT PREMIUM');

            $cmo = $this->getCmoValue($item);

            $totalBooking = $relatedBooking->sum(fn($data) => ($data->week1 ?? 0) + ($data->week2 ?? 0) + ($data->week3 ?? 0) + ($data->week4 ?? 0));

            $cmoProductivity = $cmo > 0 ? round($totalBooking / $cmo, 2) : 0;

            return [

                'nama_dealer' => Dealer::getNamaDealerByKode($item->kode_dealer),
                'leasing' => $item->leasing,
                'target_incoming' => $item->target_incoming,
                'target_booking' => $item->target_booking,
                'booking_at_lpm' => $item->booking_at_lpm,
                'booking_at_classy' => $item->booking_at_classy,
                'booking_at_premium' => $item->booking_at_premium,
                'yod_fid_nov_2024' => $item->yod_fid_nov_2024,
                'booking_week1' => $relatedBooking->sum(fn($data) => $data->week1 ?? 0),
                'booking_week2' => $relatedBooking->sum(fn($data) => $data->week2 ?? 0),
                'booking_week3' => $relatedBooking->sum(fn($data) => $data->week3 ?? 0),
                'booking_week4' => $relatedBooking->sum(fn($data) => $data->week4 ?? 0),
                'booking_at_lpm_week1' => $bookingAtLPM['week1'],
                'booking_at_lpm_week2' => $bookingAtLPM['week2'],
                'booking_at_lpm_week3' => $bookingAtLPM['week3'],
                'booking_at_lpm_week4' => $bookingAtLPM['week4'],
                'total_booking_at_lpm' => $bookingAtLPM['total'],
                'booking_at_classy_week1' => $bookingAtClassy['week1'],
                'booking_at_classy_week2' => $bookingAtClassy['week2'],
                'booking_at_classy_week3' => $bookingAtClassy['week3'],
                'booking_at_classy_week4' => $bookingAtClassy['week4'],
                'total_booking_at_classy' => $bookingAtClassy['total'],
                'booking_at_premium_week1' => $bookingAtPremium['week1'],
                'booking_at_premium_week2' => $bookingAtPremium['week2'],
                'booking_at_premium_week3' => $bookingAtPremium['week3'],
                'booking_at_premium_week4' => $bookingAtPremium['week4'],
                'total_booking_at_premium' => $bookingAtPremium['total'],
                'cmo' => $cmo,
                'cmo_productivity' => $cmoProductivity,
                'incoming_week1' => $relatedIncoming->week1 ?? 0,
                'incoming_week2' => $relatedIncoming->week2 ?? 0,
                'incoming_week3' => $relatedIncoming->week3 ?? 0,
                'incoming_week4' => $relatedIncoming->week4 ?? 0,
                'total_incoming' => $this->calculateTotalIncoming($relatedIncoming),
                'total_booking' => $totalBooking,
            ];
        });

        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true])->loadView('pdf.export', [
            'persentase' => $persentase,
            'mergedData' => $mergedData,
            'kodeDealer' => $kodeDealerRequest,
            'leasing' => $leasing,
            'dealers' => Tgtadira::distinct()->pluck('dealer', 'kode_dealer'),
            'tanggal' => $tanggal,
            'namapt' => $namapt,
            'namaDealer' => $namaDealer,
            'kendala' => $kendala,
            'perbaikan' => $perbaikan,
            'foto_diskus_base64' => $foto_diskus_base64,
            'foto_briefing_base64' => $foto_briefing_base64,
        ]);

        return $pdf->stream('laporan_rekomendasi_perbaikan.pdf');
    }

    public function exportExcel(Request $request)
    {
        $kodeDealer = Auth::user()->kode_dealer;
        $leasing = $request->post('table_type');
        // You can pass additional parameters to the export class based on your filtering logic

        return Excel::download(new SuratExport($kodeDealer, $leasing), 'surat_export.xlsx');
    }
}
