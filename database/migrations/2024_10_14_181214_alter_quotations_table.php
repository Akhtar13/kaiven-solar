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
        Schema::table('quotations', function (Blueprint $table) {
            $table->unsignedBigInteger('panel_brand_id')->after('user_name');
            $table->unsignedBigInteger('quality_preference_id')->after('panel_brand_id');
            $table->foreign('panel_brand_id')->references('id')->on('panel_brands')->onDelete('cascade');
            $table->foreign('quality_preference_id')->on('quality_preferences')->references('id')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign(['panel_brand_id']);
            $table->dropForeign(['quality_preference_id']);
            $table->dropColumn('panel_brand_id');
            $table->dropColumn('quality_preference_id');
        });   
    }
};
