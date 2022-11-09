<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('journal')->nullable();
            $table->string('part')->nullable();
            $table->string('number')->nullable();
            $table->string('pages')->nullable();
            $table->string('publisher')->nullable();
            $table->string('country')->nullable();
            $table->string('patent_number')->nullable();
            $table->string('app_number')->nullable();
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
            $table->dropColumn([
                'journal',
                'part',
                'number',
                'pages',
                'publisher',
                'country',
                'patent_number',
                'app_number',
                ]);
        });
    }
}
