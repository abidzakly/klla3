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
        Schema::table('monitoring_do_spk', function (Blueprint $table) {
            // tambah mpp_do dan mpp_spk
            $table->integer('mpp')->nullable()->after('act_do');
            // tambah productivity_do dan productivity_spk
            $table->float('productivity')->nullable()->after('gap_do');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitoring_do_spk', function (Blueprint $table) {
            //
        });
    }
};
