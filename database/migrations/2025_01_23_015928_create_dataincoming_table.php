<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dataincoming', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('kode_dealer'); // Kolom untuk kode dealer
            $table->string('leasing'); // Kolom untuk leasing

            $table->date('tgl_order'); // Kolom untuk tanggal order
            $table->string('nama_pemohon');
            $table->decimal('otr', 15, 2);
            $table->decimal('dp_gross', 15, 2);
            $table->decimal('dp_percent', 5, 2); // Persentase DP (maks 100.00)
            $table->decimal('nilai_angsuran', 15, 2);
            $table->integer('tenor');
            $table->string('pekerjaan_pemohon');
            $table->string('status_pooling');
            $table->string('alasan_reject');

            // Index untuk kolom filter
            $table->index('kode_dealer');
            $table->index('tgl_order');
            $table->index('leasing');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dataincoming');
    }
};
