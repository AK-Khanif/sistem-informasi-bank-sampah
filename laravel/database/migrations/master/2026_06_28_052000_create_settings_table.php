<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('rw_name', 100);
            $table->text('rw_address')->nullable();
            $table->string('rw_phone', 20)->nullable();
            $table->string('bank_sampah_name', 150);
            $table->string('deposit_prefix', 10);
            $table->string('sale_prefix', 10);
            $table->string('customer_prefix', 10);
            $table->boolean('backup_enabled')->default(false);
            $table->integer('backup_retention_days')->default(30);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
