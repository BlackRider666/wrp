<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->unsignedBigInteger('structural_unit_id');
        });
        Schema::table('works', function (Blueprint $table) {
            $table->foreign('structural_unit_id')
                ->references('id')->on('structural_units')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropForeign(['structural_unit_id']);
            $table->dropColumn(['structural_unit_id']);
        });
    }
}
