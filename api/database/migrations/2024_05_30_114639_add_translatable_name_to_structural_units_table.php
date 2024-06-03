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
        Schema::table('structural_units', function (Blueprint $table) {
            $table->string('name')->type('json')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('structural_units', function (Blueprint $table) {
            Schema::table('structural_units', function (Blueprint $table) {
                $table->json('name')->type('string')->change();
            });
        });
    }
};
