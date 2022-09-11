<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataDokumenBu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_dokumen_kta', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('id_detail_kta');
            $table->string('file_ktp_pjbu', 50);
            $table->string('file_foto_pjbu', 50);
            $table->string('file_npwp_pjbu', 50);
            $table->string('file_npwp_bu', 50);
            $table->string('file_akte_pendirian_perubahan_bu', 50);
            $table->string('file_sk_pendirian_perubahan_bu', 50);
            $table->string('file_skdp_bu', 50);
            $table->string('file_siup', 50);
            $table->string('file_tdp', 50);
            $table->string('file_nib', 50)->nullable();
            $table->string('file_kta', 50)->nullable();
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
        Schema::dropIfExists('t_dokumen_kta');
    }
}
