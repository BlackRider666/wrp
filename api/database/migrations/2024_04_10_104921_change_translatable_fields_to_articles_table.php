<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTranslatableFieldsToArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['title','desc','full_text']);
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->json('title');
            $table->json('desc')->nullable();
            $table->json('full_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['title','desc','full_text']);
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title');
            $table->text('desc')->nullable();
            $table->longText('full_text')->nullable();
        });
    }
}
