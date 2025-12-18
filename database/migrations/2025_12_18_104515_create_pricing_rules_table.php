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
        Schema::create(config('pricing-engine.table_names.pricing_rules'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('priority')->default(0);
            $table->json('conditions');
            $table->json('actions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('pricing-engine.table_names.pricing_rules'));
    }
};
