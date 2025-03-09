<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monitoring_do_spk', function (Blueprint $table) {
            $table->ulid('id_monitoring_do_spk')->primary();
            $table->string('nama_supervisor');
            $table->integer('target_do')->nullable();
            $table->integer('act_do')->nullable();
            $table->float('gap_do')->nullable();
            $table->float('ach_do')->nullable();
            $table->integer('target_spk')->nullable();
            $table->integer('act_spk')->nullable();
            $table->float('gap_spk')->nullable();
            $table->float('ach_spk')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_do_spk');
    }
};
