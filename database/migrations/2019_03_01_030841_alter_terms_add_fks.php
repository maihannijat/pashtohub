<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTermsAddFks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('terms', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete(null);
        });

        Schema::table('term_examples', function($table) {
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
        });

        Schema::table('term_synonyms', function($table) {
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
        });

        Schema::table('term_variations', function($table) {
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
        });

        Schema::table('term_translations', function($table) {
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
        });

        Schema::table('term_definitions', function($table) {
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('term_examples', function($table) {
            $table->dropForeign('term_examples_term_id_foreign');
        });

        Schema::table('terms', function($table) {
            $table->dropForeign('terms_user_id_foreign');
        });

        Schema::table('term_synonyms', function($table) {
            $table->dropForeign('term_synonyms_term_id_foreign');
        });

        Schema::table('term_variations', function($table) {
            $table->dropForeign('term_variations_term_id_foreign');
        });

        Schema::table('term_translations', function($table) {
            $table->dropForeign('term_translations_term_id_foreign');
        });

        Schema::table('term_definitions', function($table) {
            $table->dropForeign('term_definitions_term_id_foreign');
        });
    }
}
