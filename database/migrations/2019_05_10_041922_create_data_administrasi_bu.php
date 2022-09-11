<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataAdministrasiBu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_administrasi_kta', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('id_detail_kta');
            $table->text('alamat', 500);
            $table->string('kecamatan', 30);
            $table->string('kota', 30);
            $table->string('kd_pos', 30);
            $table->string('no_telp', 13);
            $table->string('no_fax', 30)->nullable();
            $table->string('website', 40)->nullable();
            $table->timestamps();

            $table->foreign('id_detail_kta')
            ->references('id')
            ->on('t_detail_kta')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_administrasi_kta');
    }
}
