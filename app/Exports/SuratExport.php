<?php

namespace App\Exports;

use App\Models\Tgtadira;
use App\Models\DataIncoming;
use App\Models\DataBooking;
use App\Models\Dealer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuratExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Fetch the necessary data like you did before
        $data = collect();

        // Combine your data into a single collection, just like you did with $mergedData
        // Example:
        $dataTarget = Tgtadira::all(); // Use appropriate query logic

        foreach ($dataTarget as $item) {
            $relatedIncoming = DataIncoming::where('kode_dealer', $item->kode_dealer)->first();
            $relatedBooking = DataBooking::where('req_dealer', $item->kode_dealer)->first();
            // You can process and merge the data for export here

            $data->push([
                'nama_dealer' => $item->dealer,
                'leasing' => $item->leasing,
                'target_incoming' => $item->target_incoming,
                'target_booking' => $item->target_booking,
                'booking_at_lpm' => $relatedBooking ? $relatedBooking->booking_at_lpm : null,
                'booking_at_classy' => $relatedBooking ? $relatedBooking->booking_at_classy : null,
                // Add other necessary fields
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Nama Dealer',
            'Leasing',
            'Target Incoming',
            'Target Booking',
            'Booking at LPM',
            'Booking at Classy',
            // Add other headings based on your data
        ];
    }
}
