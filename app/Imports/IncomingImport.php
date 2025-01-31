<?php

namespace App\Imports;

use App\Models\DataIncoming;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IncomingImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        $tglOrder = $row['tgl_order'];

        if ($tglOrder === 'Tgl Order' || empty($tglOrder)) {
            return null;
        }

        if (is_numeric($tglOrder)) {
            $tglOrder = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tglOrder)->format('Y-m-d');
        }

        $dpPercent = isset($row['dp_percent']) ? $row['dp_percent'] : null;

        if ($dpPercent) {
            $dpPercent = str_replace('%', '', $dpPercent);
            $dpPercent = (float) $dpPercent / 100;
        } else {
            $dpPercent = 0;
        }

        return new DataIncoming([
            'kode_dealer' => $row['kode_dealer'],
            'tgl_order' => $tglOrder,
            'nama_pemohon' => $row['nama_pemohon'],
            'leasing' => $row['leasing'],
            'otr' => $row['otr'],
            'dp_gross' => $row['dp_gross'],
            'dp_percent' => $dpPercent,
            'nilai_angsuran' => $row['nilai_angsuran'],
            'tenor' => $row['tenor'],
            'pekerjaan_pemohon' => $row['pekerjaan_pemohon'],
            'status_pooling' => $row['status_pooling'],
            'alasan_reject' => $row['alasan_reject'],
        ]);
    }
}
