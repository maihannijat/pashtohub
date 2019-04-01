<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id')->unsigned();
            $table->char('email', 255)->nullable(false)->unique();
            $table->char('first_name', 255)->nullable(false);
            $table->char('last_name', 255)->nullable(true);
            $table->integer('status_id')->nullable(false);
            $table->string('password', 64)->nullable(false);
            $table->timestamp('password_forgot_time')->nullable(true);
            $table->string('token', 64)->nullable(true);
            $table->integer('country_id')->nullable(true);
            $table->string('phone', 10)->nullable(true);
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
        Schema::dropIfExists('users');
    }
}
