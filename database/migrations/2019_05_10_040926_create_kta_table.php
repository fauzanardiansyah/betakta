<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKtaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_kta', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('id_registrasi_users')->unsigned();
            $table->integer('id_dp')->unsigned();
            $table->string('jenis_bu');
            $table->string('lokasi_pengurusan');
            $table->string('no_kta')->nullable();
            $table->integer('status_kta');
            $table->string('kualifikasi');
            $table->timestamps();

            $table->foreign('id_registrasi_users')
            ->references('id')
            ->on('t_registrasi_users')
            ->onDelete('cascade');

            $table->foreign('id_dp')
            ->references('id')
            ->on('t_dp')
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
        Schema::dropIfExists('t_kta');
    }
}
