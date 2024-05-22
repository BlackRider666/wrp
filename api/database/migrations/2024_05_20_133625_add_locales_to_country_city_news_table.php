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
        Schema::table('countries', function (Blueprint $table) {
            $table->string('name')->type('json')->change();
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->string('name')->type('json')->change();
        });
        Schema::table('news', function (Blueprint $table) {
            $table->string('title')->type('json')->change();
            $table->string('sub_title')->type('json')->change();
            $table->text('text')->type('json')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->json('title')->type('string')->change();
            $table->json('sub_title')->type('string')->change();
            $table->json('text')->type('text')->change();
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->json('name')->type('string')->change();
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->json('name')->type('string')->change();
        });
    }
};
