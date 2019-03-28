<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPashtovalToLookups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lookups', function (Blueprint $table) {
            $table->char('pashto_value', 50)->nullable(false)->after('lookup_value');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lookups', function (Blueprint $table) {
        $table->dropColumn('pashto_value');
        });
    }
}
