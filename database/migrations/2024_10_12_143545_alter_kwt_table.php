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
        Schema::table('kwt', function (Blueprint $table) {
            $table->string('suggestion_one')->after('to_kwt')->default(0);
            $table->string('suggestion_two')->after('suggestion_one')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kwt', function (Blueprint $table) {
            $table->dropColumn('suggestion_one');
            $table->dropColumn('suggestion_two');
        });
    }
};
