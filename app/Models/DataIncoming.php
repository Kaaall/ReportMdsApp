<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataIncoming extends Model
{
    use HasFactory;

    protected $table = 'dataincoming';


    protected $fillable = [
        'kode_dealer',
        'tgl_order',
        'nama_pemohon',
        'leasing',
        'otr',
        'dp_gross',
        'dp_percent',
        'nilai_angsuran',
        'tenor',
        'pekerjaan_pemohon',
        'status_pooling',
        'alasan_reject',

    ];

    public function Tgtadira()
    {
        return $this->hasMany(DataIncoming::class, 'kode_dealer', 'kode_dealer');
    }
    public function Tgtbaf()
    {
        return $this->hasMany(DataIncoming::class, 'kode_dealer', 'kode_dealer');
    }
    public function Tgtimfif()
    {
        return $this->hasMany(DataIncoming::class, 'kode_dealer', 'kode_dealer');
    }
    public function Tgtmaf()
    {
        return $this->hasMany(DataIncoming::class, 'kode_dealer', 'kode_dealer');
    }
    public function Tgtmmf()
    {
        return $this->hasMany(DataIncoming::class, 'kode_dealer', 'kode_dealer');
    }
    public function Tgtoto()
    {
        return $this->hasMany(DataIncoming::class, 'kode_dealer', 'kode_dealer');
    }
    public function Tgtwom()
    {
        return $this->hasMany(DataIncoming::class, 'kode_dealer', 'kode_dealer');
    }
}
