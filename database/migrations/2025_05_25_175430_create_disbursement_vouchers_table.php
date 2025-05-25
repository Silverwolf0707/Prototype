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
        Schema::create('disbursement_voucher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patient_records')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // accounting user
            $table->string('dv_code');
            $table->date('dv_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disbursement_vouchers');
    }
};
