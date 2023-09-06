<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsFieldsToOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('site')->nullable();
            $table->string('phone')->nullable();
            $table->json('desc');
        });
        Schema::table('organization', function (Blueprint $table) {
            $table->dropColumn(['name']);
        });
        Schema::table('organization', function (Blueprint $table) {
            $table->json('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization', function (Blueprint $table) {
            $table->dropColumn(['address','zip_code','site','phone','desc','name']);
            $table->string('name');
        });
    }
}
