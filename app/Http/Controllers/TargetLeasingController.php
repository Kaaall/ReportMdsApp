<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TgtImport;
use Illuminate\Support\Facades\DB;
use App\Models\DataBooking;

class TargetLeasingController extends Controller
{
    protected $allowedTables = ['adira', 'baf', 'imfi', 'maf', 'oto', 'mmf', 'wom']; // Daftar yang diperbolehkan

    public function index(Request $request)
    {
        $tableType = strtolower($request->input('table_type', 'adira'));


        if (!in_array($tableType, $this->allowedTables)) {
            return abort(404, "Tipe tabel tidak valid.");
        }
        $tableName = "tgt{$tableType}";
        $tableData = DB::table($tableName)->get();
        $tableData = $this->addBookingData($tableData);

        return view('upload.target', [
            'tableData' => $tableData,
            'tableType' => $tableType
        ]);
    }

    private function addBookingData($tableData)
    {
        foreach ($tableData as $row) {
            $kodeDealer = $row->dealer ?? null;
            $leasing = $row->leasing ?? null;

            if ($kodeDealer && $leasing) {
                $row->booking_at_lpm = $this->getBookingCategory($kodeDealer, $leasing, 'AT LPM');
                $row->booking_at_classy = $this->getBookingCategory($kodeDealer, $leasing, 'AT Classy');
                $row->booking_at_premium = $this->getBookingCategory($kodeDealer, $leasing, 'AT Premium');
            } else {
                $row->booking_at_lpm = $row->booking_at_classy = $row->booking_at_premium = [
                    'week1' => 0,
                    'week2' => 0,
                    'week3' => 0,
                    'week4' => 0,
                    'total' => 0
                ];
            }
        }

        return $tableData;
    }

    private function getBookingCategory($kodeDealer, $leasing, $category)
    {
        $data = DataBooking::where('req_dealer', strtoupper($kodeDealer))
            ->where('leasing', strtoupper($leasing))
            ->where('category', $category)
            ->whereBetween('request_date', ['2024-12-01', '2024-12-31'])
            ->select(
                DB::raw("SUM(CASE WHEN DAY(request_date) BETWEEN 1 AND 7 THEN 1 ELSE 0 END) as week1"),
                DB::raw("SUM(CASE WHEN DAY(request_date) BETWEEN 8 AND 14 THEN 1 ELSE 0 END) as week2"),
                DB::raw("SUM(CASE WHEN DAY(request_date) BETWEEN 15 AND 21 THEN 1 ELSE 0 END) as week3"),
                DB::raw("SUM(CASE WHEN DAY(request_date) BETWEEN 22 AND 31 THEN 1 ELSE 0 END) as week4"),
                DB::raw("COUNT(*) as total")
            )
            ->first();

        return $data ? [
            'week1' => $data->week1,
            'week2' => $data->week2,
            'week3' => $data->week3,
            'week4' => $data->week4,
            'total' => $data->total,
        ] : [
            'week1' => 0,
            'week2' => 0,
            'week3' => 0,
            'week4' => 0,
            'total' => 0,
        ];
    }

    public function upload(Request $request)
    {
        $request->validate([
            'excel' => 'required|file|mimes:xlsx,xls',
            'table_type' => 'required|in:adira,baf,imfi,maf,oto,mmf,wom',
        ]);

        $tableType = $request->input('table_type');

        Excel::import(new TgtImport($tableType), $request->file('excel'));

        return redirect()->route('index.target')->with('success', 'Data berhasil diunggah ke ' . ucfirst($tableType));
    }
}
