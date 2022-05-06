<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_user', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('user_id');
        });

        Schema::table('article_user', function (Blueprint $table) {
            $table->foreign('article_id')
                ->references('id')->on('articles');
            $table->foreign('user_id')
                ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_user', function (Blueprint $table) {
            $table->dropForeign(['article_id', 'user_id']);
        });
        Schema::dropIfExists('article_user');
    }
}
