<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id')->unsigned();
            $table->char('term', 255)->nullable(false);
            $table->integer('term_lang_id')->nullable(true)->unsigned();
            $table->integer('origin_id')->nullable(true)->unsigned();
            $table->integer('user_id')->nullable(false)->unsigned();
            $table->integer('lang_part_id')->nullable(true)->unsigned();
            $table->integer('nativity_scale')->nullable(true)->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terms');
    }
}
