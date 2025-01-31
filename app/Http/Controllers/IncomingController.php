<?php

namespace App\Http\Controllers;

use App\Models\DataIncoming;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IncomingImport;

class IncomingController extends Controller
{

    public function index(Request $request)
    {
        $query = DataIncoming::query();

        if ($request->filled('kode_dealer')) {
            $query->where('kode_dealer', $request->kode_dealer);
        }

        if ($request->filled('tgl_order_start') && $request->filled('tgl_order_end')) {
            $query->whereBetween('tgl_order', [$request->tgl_order_start, $request->tgl_order_end]);
        }

        if ($request->filled('leasing')) {
            $query->where('leasing', $request->leasing);
        }

        $incoming = $query->paginate(10);

        return view('upload.incoming', compact('incoming'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new IncomingImport, $request->file('file'));

        return redirect()->route('upload.incoming')->with('success', 'Data berhasil diimpor!');
    }
}
