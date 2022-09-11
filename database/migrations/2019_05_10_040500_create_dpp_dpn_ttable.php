<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDppDpnTtable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_dp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_provinsi')->unsigned();
            $table->integer('level');
            $table->string('no_rek');
            $table->string('nm_rek');
            $table->string('kode_bank');
            $table->string('ttd');
            $table->string('rate_fee_buat_baru');
            $table->string('rate_fee_perpanjang');
            $table->string('jml_tagihan_buat_baru_kecil');
            $table->string('jml_tagihan_buat_baru_menengah');
            $table->string('jml_tagihan_buat_baru_besar');
            $table->string('jml_tagihan_perpanjang_kecil');
            $table->string('jml_tagihan_perpanjang_menengah');
            $table->string('jml_tagihan_perpanjang_besar');
            $table->timestamps();

            $table->foreign('id_provinsi')
            ->references('id')
            ->on('provinsi')
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
        Schema::dropIfExists('t_dp');
    }
}
