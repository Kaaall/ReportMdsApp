<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('databooking', function (Blueprint $table) {
            $table->id();
            $table->string('leasing_request')->nullable();
            $table->string('model_name');
            $table->string('leasing');
            $table->date('request_date');
            $table->string('req_dealer');
            $table->string('category');
            $table->string('period');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databooking');
    }
};
