<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'kode_dealer',
        'tgl_order',
        'nama_pemohon',
        'type_motor',
        'frame_tahun',
        'leasing',
        'otr',
        'dp_gross',
        'dp_percent',
        'nilai_angsuran',
        'tenor',
        'pekerjaan_pemohon',
        'status_rumah',
        'status_pooling',
        'alasan_reject',
        'category'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->type_motor)) {
                $model->type_motor = 'Tidak Diketahui';
            }

            if (empty($model->status_rumah)) {
                $model->status_rumah = 'Tidak Diketahui';
            }
            if (empty($model->frame_tahun)) {
                $model->frame_tahun = 0;
            }
        });
    }
}
