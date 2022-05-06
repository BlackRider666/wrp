<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStructuralUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structural_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('organization_id');
            $table->timestamps();
        });
        Schema::table('structural_units', function (Blueprint $table) {
            $table->foreign('organization_id')
                ->references('id')->on('organization')
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
        Schema::table('structural_units', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });
        Schema::dropIfExists('structural_units');
    }
}
