<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangidToTermVariations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('term_variations', function (Blueprint $table) {
            $table->integer('lang_id')->nullable(false)->after('variant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('term_variations', function (Blueprint $table) {
            $table->dropColumn('lang_id');
        });
    }
}