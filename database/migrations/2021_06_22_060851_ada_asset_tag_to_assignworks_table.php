<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdaAssetTagToAssignworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignworks', function (Blueprint $table) {
            //
            $table->string('asset_tag',250)->nullable()->default(NULL);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assignworks', function (Blueprint $table) {
            //

            $table->dropColumn('asset_tag');
        });
    }
}
