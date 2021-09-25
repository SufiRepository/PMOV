<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemarkToBillquantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billquantities', function (Blueprint $table) {
            //
            $table->string('remark')->nullable();
            $table->string('option')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billquantities', function (Blueprint $table) {
            //
            $table->dropColumn('remark');
            $table->dropColumn('option');

        });
    }
}
