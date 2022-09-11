<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailLegalitasBu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_detail_legalitas_kta', function (Blueprint $table) {
     
            $table->increments('id');
          
            $table->integer('id_legalitas_bu')->unsigned();
            $table->string('no_akte_perubahan')->nullable();
            $table->string('nm_notaris_perubahan')->nullable();
            $table->date('tgl_akte_perubahan_keluar')->nullable();
            
            $table->string('no_sk_perubahan')->nullable();
            $table->string('penerbit_sk_perubahan')->nullable();
            $table->date('tgl_sk_perubahan_keluar')->nullable();

            $table->foreign('id_legalitas_bu')
            ->references('id')
            ->on('t_legalitas_kta')
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
        Schema::dropIfExists('t_detail_legalitas_kta');
    }
}
