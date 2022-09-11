<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataLegalitasBu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_legalitas_kta', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('id_detail_kta');
            $table->string('no_siup', 50);
            $table->string('penerbit_siup', 50);
            $table->date('tgl_keluar_siup');
            $table->date('masa_berlaku_siup');

            $table->string('no_skdp', 50);
            $table->string('penerbit_skdp', 50);
            $table->date('tgl_keluar_skdp');
            $table->date('masa_berlaku_skdp');

            $table->string('no_akte', 50);
            $table->string('nm_notaris', 50);
            $table->date('tgl_keluar_akte');

            $table->string('no_sk_pendirian', 50);
            $table->string('penerbit_sk_pendirian', 50);
            $table->date('tgl_sk_pendirian_keluar');
            
            $table->string('no_tdp', 50);
            $table->string('penerbit_tdp', 50);
            $table->date('tgl_keluar_tdp');
            $table->date('masa_berlaku_tdp');

            $table->string('no_nib', 50);
            $table->string('penerbit_nib', 50);
            $table->date('tgl_keluar_nib');
            $table->date('masa_berlaku_nib');
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
        Schema::dropIfExists('t_legalitas_kta');
    }
}
