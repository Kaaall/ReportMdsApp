<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TgtImport implements ToModel, WithHeadingRow
{
    protected $type;

    public function __construct($type)
    {
        $this->type = ucfirst(strtolower($type)); // Pastikan formatnya konsisten (huruf pertama besar)
    }

    public function model(array $row)
    {
        $data = [
            'kode_dealer' => $row['kode_dealer'],
            'dealer' => $row['dealer'],
            'leasing' => $row['leasing'],
            'target_incoming' => $row['target_incoming'],
            'target_booking' => $row['target_booking'],
            'cmo' => $row['cmo'],
            'booking_at_lpm' => $row['booking_at_lpm'],
            'booking_at_classy' => $row['booking_at_classy'],
            'booking_at_premium' => $row['booking_at_premium'],
            'yod_fid_nov_2024' => $row['yod_fid'],
        ];

        // Buat nama model secara dinamis
        $className = "App\\Models\\Tgt{$this->type}";

        if (class_exists($className)) {
            return new $className($data);
        }

        return null;
    }
}
