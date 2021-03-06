<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTermsAddTermsSynonymsFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('term_synonyms', function($table) {
            $table->foreign('term_id')->references('id')->on('terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('term_synonyms', function($table) {
            $table->dropForeign('term_synonyms_term_id_foreign');
        });
    }
}
