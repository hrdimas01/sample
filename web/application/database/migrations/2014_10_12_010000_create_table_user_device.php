<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_device', function (Blueprint $table) {
            $table->increments('usd_id');
            $table->string('usd_token')->nullable();
            $table->string('usd_operating_system')->nullable();
            $table->string('usd_model')->nullable();
            $table->string('usd_imei')->nullable();
            $table->string('usd_build_number')->nullable();
            $table->integer('created_by')->nullable()->default('0');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
