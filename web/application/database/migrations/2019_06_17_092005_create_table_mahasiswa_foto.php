<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMahasiswaFoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_foto', function(Blueprint $table)
        {
            $table->increments('mhf_id');
            $table->integer('mhf_mhs_id')->nullable()->unsigned();
            $table->string('mhf_nama_file')->nullable();
            $table->string('mhf_keterangan_file')->nullable();
            $table->string('mhf_path_file')->nullable();
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
