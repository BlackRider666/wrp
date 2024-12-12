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
        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn('position');
        });
        Schema::table('works', function (Blueprint $table) {
            $table->json('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('works', function (Blueprint $table) {
            Schema::table('works', function (Blueprint $table) {
                $table->dropColumn('position');
            });
            Schema::table('works', function (Blueprint $table) {
                $table->string('position');
            });
        });
    }
};
