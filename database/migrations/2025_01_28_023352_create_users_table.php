<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('password')->unique(); // Kolom password
            $table->string('kode_dealer')->unique(); // Kolom kode dealer (nullable jika tidak wajib)
            $table->string('role')->default('user'); // Menambahkan kolom role dengan default 'user'
            $table->rememberToken(); // Token untuk "remember me"
            $table->timestamps(); // Created_at dan Updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
