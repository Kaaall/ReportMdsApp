<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;


    protected $table = 'dealers';


    protected $fillable = [
        'kode_dealer',
        'nama_dealer',
    ];


    public $timestamps = true;

    /**
     * F
     *
     * @param string $kodeDealer
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public static function findByKodeDealer($kodeDealer)
    {
        return self::where('kode_dealer', strtoupper($kodeDealer))->first();
    }

    /**
     * Fungsi untuk mendapatkan nama dealer berdasarkan kode_dealer.
     *
     * @param string $kodeDealer
     * @return string|null
     */
    public static function getNamaDealerByKode($kodeDealer)
    {
        $dealer = self::findByKodeDealer($kodeDealer);
        return $dealer ? $dealer->nama_dealer : null;
    }

    /**
     * Relasi dengan tabel Tgtadira.
     * Menghubungkan dealer dengan data target.
     */
    public function tgtadira()
    {
        return $this->hasMany(Tgtadira::class, 'kode_dealer', 'kode_dealer');
    }

    /**
     * Relasi dengan tabel Tgtbaf.
     * Menghubungkan dealer dengan data target untuk BAF.
     */
    public function tgtbaf()
    {
        return $this->hasMany(Tgtbaf::class, 'kode_dealer', 'kode_dealer');
    }

    /**
     * Relasi dengan tabel Tgtimfi.
     * Menghubungkan dealer dengan data target untuk IMFI.
     */
    public function tgtimfi()
    {
        return $this->hasMany(Tgtimfi::class, 'kode_dealer', 'kode_dealer');
    }

    /**
     * Relasi dengan tabel DataBooking.
     * Menghubungkan dealer dengan data booking.
     */
    public function dataBooking()
    {
        return $this->hasMany(DataBooking::class, 'req_dealer', 'kode_dealer');
    }

    /**
     * Relasi dengan tabel DataIncoming.
     * Menghubungkan dealer dengan data incoming.
     */
    public function dataIncoming()
    {
        return $this->hasMany(DataIncoming::class, 'kode_dealer', 'kode_dealer');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'kode_dealer');
    }
}
