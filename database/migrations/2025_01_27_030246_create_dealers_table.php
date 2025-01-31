<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealersTable extends Migration
{
    public function up()
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_dealer')->unique();
            $table->string('nama_dealer');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dealers');
    }
}
