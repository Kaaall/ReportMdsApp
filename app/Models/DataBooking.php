<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataBooking extends Model
{
    use HasFactory;


    protected $table = 'databooking';


    protected $fillable = [
        'leasing_request',
        'model_name',
        'leasing',
        'request_date',
        'req_dealer',
        'category',
        'period',
    ];

    // Relasi ke Tgtadira
    public function tgtadira()
    {
        return $this->belongsTo(Tgtadira::class, 'req_dealer', 'kode_dealer')
            ->where('category', $this->category);
    }

    public function tgtbaf()
    {
        return $this->belongsTo(Tgtbaf::class, 'req_dealer', 'kode_dealer')
            ->where('category', $this->category);
    }

    public function tgtimfi()
    {
        return $this->belongsTo(Tgtimfi::class, 'req_dealer', 'kode_dealer')
            ->where('category', $this->category);
    }
    public function tgtmaf()
    {
        return $this->belongsTo(Tgtmaf::class, 'req_dealer', 'kode_dealer')
            ->where('category', $this->category);
    }
    public function tgtmmf()
    {
        return $this->belongsTo(Tgtmmf::class, 'req_dealer', 'kode_dealer')
            ->where('category', $this->category);
    }
    public function tgtoto()
    {
        return $this->belongsTo(Tgtoto::class, 'req_dealer', 'kode_dealer')
            ->where('category', $this->category);
    }
    public function tgtwom()
    {
        return $this->belongsTo(Tgtwom::class, 'req_dealer', 'kode_dealer')
            ->where('category', $this->category);
    }
}
