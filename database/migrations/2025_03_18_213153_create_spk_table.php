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
        Schema::create('spk', function (Blueprint $table) {
            $table->uuid('id_spk')->primary();
            $table->string('nomor_spk');
            $table->string('customer_name_1');
            $table->string('customer_name_2')->nullable();
            $table->string('payment_method');
            $table->string('leasing')->nullable();
            $table->string('model');
            $table->string('type');
            $table->string('color');
            $table->string('sales');
            $table->string('branch');
            $table->string('status');
            $table->decimal('total_payment', 15, 2);
            $table->string('customer_type');
            $table->string('fleet');
            $table->string('color_code');
            $table->string('branch_id_text');
            $table->string('type_id');
            $table->boolean('valid');
            $table->date('valid_date');
            $table->string('custom_type')->nullable();
            $table->string('spk_status');
            $table->string('supervisor')->nullable();
            $table->date('date_if_credit_agreement')->nullable();
            $table->date('po_date')->nullable();
            $table->string('po_number')->nullable();
            $table->string('buyer_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('sub_district')->nullable();
            $table->date('date_spk');
            $table->timestamps();
            
            // Hapus foreign key constraint karena menyebabkan masalah
            // $table->foreign('branch_id_text')->references('id_branch')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spk');
    }
};
