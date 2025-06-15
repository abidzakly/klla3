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
        Schema::table('spk', function (Blueprint $table) {
            if (Schema::hasColumn('spk', 'branch_id')) {
                $table->dropColumn('branch_id');
            }
        });

        Schema::table('spk', function (Blueprint $table) {
            $table->string('branch_id_text')->after('color_code');
            $table->ulid('branch_id')->after('id_spk')->nullable();
            $table->foreign('branch_id')
                ->references('id_branch')
                ->on('branches')
                ->onDelete('cascade');
            $table->timestamp('date_spk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spk', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
            $table->dropColumn('branch_id_text');
            $table->dropColumn('date_spk');
        });
    }
};
