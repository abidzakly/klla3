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
            $table->timestamp('date')->nullable()->after('status')->comment('Tanggal Monitoring')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitoring_do_spk', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
};
