<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            if (!Schema::hasColumns('users',['first_name_json', 'second_name_json','surname_json', 'desc_json'])) {
                $table->json('first_name_json')->nullable();
                $table->json('second_name_json')->nullable();
                $table->json('surname_json')->nullable();
                $table->json('desc_json')->nullable();
            }
        });
        if (Schema::hasColumns('users',['first_name', 'second_name', 'surname', 'desc'])) {
            DB::statement("
            UPDATE users SET
                first_name_json = JSON_OBJECT('en', first_name, 'uk', first_name),
                second_name_json = JSON_OBJECT('en', second_name, 'uk', second_name),
                surname_json = JSON_OBJECT('en', surname, 'uk', surname),
                desc_json = JSON_OBJECT('en', `desc`, 'uk', `desc`)
            ");

            Schema::table('users', static function (Blueprint $table) {
                    $table->dropColumn(['first_name', 'second_name', 'surname', 'desc']);
            });
        }

        Schema::table('users', static function (Blueprint $table) {
            $table->renameColumn('first_name_json', 'first_name');
            $table->renameColumn('second_name_json', 'second_name');
            $table->renameColumn('surname_json', 'surname');
            $table->renameColumn('desc_json', 'desc');
        });

        Schema::table('users', static function (Blueprint $table) {
            $table->json('first_name')->nullable(false)->change();
            $table->json('second_name')->nullable(false)->change();
            $table->json('surname')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->renameColumn('first_name', 'first_name_json');
            $table->renameColumn('second_name', 'second_name_json');
            $table->renameColumn('surname', 'surname_json');
            $table->renameColumn('desc', 'desc_json');
        });

        Schema::table('users', static function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('surname')->nullable();
            $table->text('desc')->nullable();
        });

        DB::statement("
            UPDATE users SET
                first_name = JSON_UNQUOTE(JSON_EXTRACT(first_name_json, '$.en')),
                second_name = JSON_UNQUOTE(JSON_EXTRACT(second_name_json, '$.en')),
                surname = JSON_UNQUOTE(JSON_EXTRACT(surname_json, '$.en')),
                `desc` = JSON_UNQUOTE(JSON_EXTRACT(`desc_json`, '$.en'))
        ");

        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn(['first_name_json', 'second_name_json', 'surname_json', 'desc_json']);
        });

        Schema::table('users', static function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->string('second_name')->nullable(false)->change();
            $table->string('surname')->nullable(false)->change();
        });
    }
};
