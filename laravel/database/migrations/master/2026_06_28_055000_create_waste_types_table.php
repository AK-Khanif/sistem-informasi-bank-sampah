<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('waste_category_id')->constrained()->cascadeOnDelete();
            $table->string('code', 10)->unique();
            $table->string('name', 100);
            $table->string('unit', 20);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['waste_category_id', 'name']);
            $table->index('code');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_types');
    }
};
