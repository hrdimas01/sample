<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMahasiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->increments('mhs_id');
            $table->string('mhs_nim', 15)->unique();
            $table->string('mhs_nama')->nullable();
            $table->string('mhs_alamat')->nullable();
            $table->string('mhs_hp', 20)->nullable();
            $table->date('mhs_tanggal_lahir')->nullable();
            $table->boolean('mhs_aktif')->nullable()->default(true);
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
        // Schema::dropIfExists('table_mahasiswa');
    }
}
