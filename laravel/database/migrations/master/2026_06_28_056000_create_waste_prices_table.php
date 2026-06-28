<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_prices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('waste_type_id')->constrained()->cascadeOnDelete();
            $table->decimal('buy_price', 12, 2);
            $table->date('effective_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('waste_type_id');
            $table->index('is_active');
            $table->index('effective_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_prices');
    }
};
