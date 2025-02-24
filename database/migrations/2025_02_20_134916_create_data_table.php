<?php

use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'nama_supervisor');
            $table->integer(column: 'target_do');
            $table->integer(column: 'act_do');
            $table->integer(column: 'gap');
            $table->float(column: 'ach');
            $table->integer(column: 'target_spk');
            $table->integer(column: 'act_spk');
            $table->integer(column: 'gap_spk');
            $table->float(column: 'ach_spk');
            $table->string(column: 'status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
