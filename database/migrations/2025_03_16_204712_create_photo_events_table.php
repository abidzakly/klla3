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
        Schema::create('photo_events', function (Blueprint $table) {
            $table->ulid('id_photo_event')->primary();
            $table->ulid('photo_event_type_id'); // Pastikan ini juga ULID agar kompatibel
            $table->ulid('branch_id'); // Pastikan ini juga ULID agar kompatibel
            $table->string('file_name')->index();
            $table->timestamps();

            // Definisikan foreign key secara eksplisit
            $table->foreign('photo_event_type_id')
                ->references('id_photo_event_type')
                ->on('photo_event_types')
                ->onDelete('cascade');
                // cabang referensi foreign key dihapus, maka data di tabel ini juga dihapus
            $table->foreign('branch_id')
                ->references('id_branch')
                ->on('branches')
                ->onDelete('cascade');
                // cabang referensi foreign key dihapus, maka data di tabel ini juga dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_events');
    }
};
