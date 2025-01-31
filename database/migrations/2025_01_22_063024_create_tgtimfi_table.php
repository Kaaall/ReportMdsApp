<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tgtimfi', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('kode_dealer')->unique();
            $table->string('dealer');
            $table->string('leasing');
            $table->float('target_incoming');
            $table->float('target_booking');
            $table->float('cmo');
            $table->float('booking_at_lpm');
            $table->float('booking_at_classy');
            $table->float('booking_at_premium');
            $table->float('yod_fid_nov_2024');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tgtimfi');
    }
};
