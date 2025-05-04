<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('monitoring_do_spk')->truncate();
        Schema::table('monitoring_do_spk', function (Blueprint $table) {
            if(Schema::hasColumn('monitoring_do_spk', 'nama_supervisor')) {
                $table->dropColumn('nama_supervisor');
            }
            $table->foreignId('id_supervisor')->after('id_monitoring_do_spk')->constrained('supervisors', 'id_supervisor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitoring_do_spk', function (Blueprint $table) {
            $table->dropForeign(['id_supervisor']);
            $table->dropColumn('id_supervisor');
            $table->string('nama_supervisor')->after('id_monitoring_do_spk');
        });
    }
};
