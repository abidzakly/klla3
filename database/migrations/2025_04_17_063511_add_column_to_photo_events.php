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
        Schema::table('photo_events', function (Blueprint $table) {
            $table->string('photo_event_name')->nullable()->after('branch_id');
            $table->string('photo_event_location')->nullable()->after('photo_event_name');
            $table->string('photo_event_caption')->nullable()->after('photo_event_location');
            $table->date('photo_event_date')->nullable()->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photo_events', function (Blueprint $table) {
            $table->dropColumn('event_name');
            $table->dropColumn('caption');
            $table->dropColumn('event_date');
        });
    }
};
