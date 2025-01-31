<?php

namespace App\Http\Controllers;

use App\Models\DataBooking;
use App\Imports\BookingImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        $query = DataBooking::query();
        $booking = $query->paginate(10);

        return view('upload.booking', compact('booking'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048',
        ]);

        Excel::import(new BookingImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }
}
