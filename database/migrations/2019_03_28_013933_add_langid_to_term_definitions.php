<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangidToTermDefinitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('term_definitions', function (Blueprint $table) {
            $table->integer('lang_id')->nullable(false)->after('definition');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('term_definitions', function (Blueprint $table) {
            $table->dropColumn('lang_id');
        });
    }
}
