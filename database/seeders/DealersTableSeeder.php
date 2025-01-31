<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DealersTableSeeder extends Seeder
{
    public function run()
    {
        $dealers = [
            ['kode_dealer' => '9FM005', 'nama_dealer' => 'PT.AS SM RAJA'],
            ['kode_dealer' => 'FAFA001', 'nama_dealer' => 'SENTRAL YAMAHA MEDAN'],
            ['kode_dealer' => '9FM012', 'nama_dealer' => 'PT.AS GATSU'],
            ['kode_dealer' => 'FAFA003', 'nama_dealer' => 'PT.AS SETIA BUDI'],
            ['kode_dealer' => 'FAFA008', 'nama_dealer' => 'PT.AS BILAL'],
            ['kode_dealer' => 'FAFA009', 'nama_dealer' => 'PT.AS MARELAN'],
            ['kode_dealer' => 'FAFA006', 'nama_dealer' => 'PT.AS AR HAKIM'],
            ['kode_dealer' => 'FBFF004', 'nama_dealer' => 'PT.AS TAMORA'],
            ['kode_dealer' => 'FBFF005', 'nama_dealer' => 'PT.AS PERBAUNGAN'],
            ['kode_dealer' => 'FBFF007', 'nama_dealer' => 'PT.AS KOTA PINANG'],
            ['kode_dealer' => 'FBFF006', 'nama_dealer' => 'PT.AS AEK KANOPAN'],
            ['kode_dealer' => 'FBFF001', 'nama_dealer' => 'PT.AS R.PRAPAT'],
            ['kode_dealer' => '9FM002', 'nama_dealer' => 'PT.AS KISARAN'],
            ['kode_dealer' => 'FBFF002', 'nama_dealer' => 'PT.AS BINJAI'],
            ['kode_dealer' => '9FM007', 'nama_dealer' => 'PT.AS SIBOLGA'],
            ['kode_dealer' => '9F0003', 'nama_dealer' => 'PT.AS SIDEMPUAN'],
            ['kode_dealer' => '9F0006', 'nama_dealer' => 'PT.AS SIANTAR'],
            ['kode_dealer' => '9FM014', 'nama_dealer' => 'PT.AS LANGSA'],
            ['kode_dealer' => '9FM006', 'nama_dealer' => 'PT.AS LHOKSEUMAWE'],
            ['kode_dealer' => 'FCFA003', 'nama_dealer' => 'PT.AS JAMBOTAPE'],
            ['kode_dealer' => 'FCFB001', 'nama_dealer' => 'PT.AS LAMBARO'],
            ['kode_dealer' => '9FM013', 'nama_dealer' => 'PT.AS BIREUN'],
            ['kode_dealer' => 'FCFB002', 'nama_dealer' => 'PT.AS KUALA SIMPANG'],
            ['kode_dealer' => '9FM010', 'nama_dealer' => 'PT.AS MEULABOH'],
            ['kode_dealer' => '9FM009', 'nama_dealer' => 'PT.AS SUSOH'],
            ['kode_dealer' => '9FM011', 'nama_dealer' => 'PT.AS SUBULUSSALAM'],
            ['kode_dealer' => 'FD00301', 'nama_dealer' => 'PT.AS SUDIRMAN'],
            ['kode_dealer' => 'FD00309', 'nama_dealer' => 'SENTRAL YAMAHA PKU'],
            ['kode_dealer' => '9F0004', 'nama_dealer' => 'PT.AS PANAM'],
            ['kode_dealer' => '9FB004', 'nama_dealer' => 'PT.AS PASIR PUTIH'],
            ['kode_dealer' => '9FB010', 'nama_dealer' => 'PT.AS NANGKA'],
            ['kode_dealer' => 'FD00305', 'nama_dealer' => 'PT.AS REBA'],
            ['kode_dealer' => '9FB009', 'nama_dealer' => 'PT.AS TEMBILAHAN'],
            ['kode_dealer' => 'FD00307', 'nama_dealer' => 'PT.AS TALUK KUANTAN'],
            ['kode_dealer' => 'FD00303', 'nama_dealer' => 'PT.AS FLAMBOYAN'],
            ['kode_dealer' => 'FD00304', 'nama_dealer' => 'PT.AS AIR TIRIS'],
            ['kode_dealer' => 'FD00308', 'nama_dealer' => 'PT.AS UJUNG BATU'],
            ['kode_dealer' => '9FB008', 'nama_dealer' => 'PT.AS PASIR PENGARAIAN'],
            ['kode_dealer' => 'FD00306', 'nama_dealer' => 'PT.AS BAGAN BATU'],
            ['kode_dealer' => '9FB006', 'nama_dealer' => 'PT.AS DURI'],
            ['kode_dealer' => 'FEFC001', 'nama_dealer' => 'PT.AS Bengkong'],
            ['kode_dealer' => 'FEFC002', 'nama_dealer' => 'PT.AS Batam Center'],
            ['kode_dealer' => '9FB001', 'nama_dealer' => 'PT.AS Botania'],
            ['kode_dealer' => '9FB012', 'nama_dealer' => 'PT.AS TEMBESI']
        ];

        DB::table('dealers')->insert($dealers);
    }
}
