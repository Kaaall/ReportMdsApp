<?php

namespace App\Imports;

use App\Models\DataBooking;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class BookingImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $requestDate = $row['request_date'] ?? null;
        if ($requestDate) {
            try {

                $requestDate = Carbon::createFromFormat('d/m/Y', $requestDate)->format('Y-m-d');
            } catch (\Exception $e) {

                $requestDate = '2025-01-01';
            }
        } else {

            $requestDate = '2025-01-01';
        }

        $modelName = $row['model_name'] ?? 'Unknown Model';
        $leasing = $row['leasing'] ?? 'Unknown Leasing';
        $category = $row['category'] ?? 'Unknown Category';
        $period = $row['period'] ?? 'Unknown Period';
        $reqDealer = $row['req_dealer'] ?? 'Unknown Dealer';

        return new DataBooking([
            'leasing_request' => $row['LeasingRequest'] ?? null,
            'model_name' => $modelName,
            'leasing' => $leasing,
            'request_date' => $requestDate,
            'req_dealer' => $reqDealer,
            'category' => $category,
            'period' => $period,
        ]);
    }
}
