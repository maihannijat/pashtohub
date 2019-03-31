<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameLangidColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('terms', function (Blueprint $table) {
            $table->renameColumn('lang_id', 'term_lang_id');
        });

        Schema::table('term_definitions', function (Blueprint $table) {
            $table->renameColumn('lang_id', 'term_lang_id');
        });

        Schema::table('term_examples', function (Blueprint $table) {
            $table->renameColumn('lang_id', 'term_lang_id');
        });

        Schema::table('term_synonyms', function (Blueprint $table) {
            $table->renameColumn('lang_id', 'term_lang_id');
        });

        Schema::table('term_translations', function (Blueprint $table) {
            $table->renameColumn('lang_id', 'term_lang_id');
        });

        Schema::table('term_variations', function (Blueprint $table) {
            $table->renameColumn('lang_id', 'term_lang_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('terms', function (Blueprint $table) {
            $table->renameColumn('term_lang_id', 'lang_id');
        });

        Schema::table('term_definitions', function (Blueprint $table) {
            $table->renameColumn('term_lang_id', 'lang_id');
        });

        Schema::table('term_examples', function (Blueprint $table) {
            $table->renameColumn('term_lang_id', 'lang_id');
        });

        Schema::table('term_synonyms', function (Blueprint $table) {
            $table->renameColumn('term_lang_id', 'lang_id');
        });

        Schema::table('term_translations', function (Blueprint $table) {
            $table->renameColumn('term_lang_id', 'lang_id');
        });

        Schema::table('term_variations', function (Blueprint $table) {
            $table->renameColumn('term_lang_id', 'lang_id');
        });
    }
}
