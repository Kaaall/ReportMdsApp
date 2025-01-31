<?php

// app/Models/Tgtimfi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tgtimfi extends Model
{
    use HasFactory;

    protected $table = 'tgtimfi';

    protected $fillable = [
        'kode_dealer',
        'dealer',
        'leasing',
        'target_incoming',
        'target_booking',
        'cmo',
        'booking_at_lpm',
        'booking_at_classy',
        'booking_at_premium',
        'yod_fid_nov_2024',
    ];

    public function Dataincoming()
    {
        return $this->hasMany(DataIncoming::class, 'kode_dealer', 'kode_dealer');
    }
    public function DataBooking()
    {
        return $this->hasMany(DataBooking::class, 'kode_dealer', 'kode_dealer', 'category');
    }
}
