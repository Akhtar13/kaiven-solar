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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('mobile_no');
            $table->unsignedBigInteger('address_type_id');
            $table->string('city')->nullable();
            $table->string('higest_billing')->nullable();
            $table->decimal('total', 10, 2)->default(0.00);
            $table->timestamps();
            $table->foreign('address_type_id')->on('address_types')->references('id')->onDelete('cascade');
        });
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id');
            $table->unsignedBigInteger('panel_brand_id');
            $table->unsignedBigInteger('quality_preference_id');
            $table->decimal('price_per_unit', 10, 1)->default(0.00);
            $table->decimal('total_price', 10, 1)->default(0.00);
            $table->integer('quantity');
            $table->timestamps();
            $table->foreign('quotation_id')->on('quotations')->references('id')->onDelete('cascade');
            $table->foreign('panel_brand_id')->on('panel_brands')->references('id')->onDelete('cascade');
            $table->foreign('quality_preference_id')->on('quality_preferences')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
