<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addcolumnpindahdpp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_detail_kta', function (Blueprint $table) {
            //
            $table->unsignedInteger('provinsi_asal')->nullable();
            $table->foreign('provinsi_asal')->references('id')->on('t_dp')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('provinsi_tujuan')->nullable();
            $table->foreign('provinsi_tujuan')->references('id')->on('t_dp')->onDelete('cascade')->onUpdate('cascade');
            $table->string('status_pindah')->nullable();
            $table->text('surat_permohonan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_detail_kta', function (Blueprint $table) {
            //
        });
    }
}
