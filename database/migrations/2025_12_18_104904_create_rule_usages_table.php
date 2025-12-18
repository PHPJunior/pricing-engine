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
        Schema::create(config('pricing-engine.table_names.rule_usages'), function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('pricing_rule_id');

            $table->decimal('discount_amount', 10, 2);
            $table->decimal('final_price', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('pricing-engine.table_names.rule_usages'));
    }
};
