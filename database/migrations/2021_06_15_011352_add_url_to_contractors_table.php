<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlToContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contractors', function (Blueprint $table) {
            //

            $table->string('url',250)->nullable()->default(NULL);
            $table->string('zip',10)->nullable()->default(NULL);
            $table->string('image')->nullable();
            $table->integer('company_id')->unsigned()->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractors', function (Blueprint $table) {
            //
            $table->dropColumn('url');
            $table->dropColumn('zip');
            $table->dropColumn('image');
            $table->dropColumn('company_id');

        });
    }
}
