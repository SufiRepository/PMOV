<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillquantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billquantities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();

            $table->integer('company_id')->nullable()->default(NULL);
            $table->integer('user_id')->nullable()->default(NULL);
            $table->integer('project_id')->nullable()->default(NULL);


            $table->string('name')->nullable();
            $table->string('serial')->nullable();
            $table->string('type')->nullable();
            $table->decimal('buy_value', 8, 2)->nullable();
            $table->decimal('sale_value', 8, 2)->nullable();
            $table->decimal('net_profit', 8, 2)->nullable();

            $table->string('image')->nullable()->default(null);


           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billquantities');
    }
}
