<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailKta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_detail_kta', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_kta');
            $table->integer('jenis_pengajuan');
            $table->datetime('waktu_pengajuan');
            $table->date('tgl_terbit')->nullable();
            $table->date('masa_berlaku');
            $table->integer('view_notifikasi');
            $table->boolean('is_inserted');
            $table->timestamps();

            $table->foreign('id_kta')
            ->references('id')
            ->on('t_kta')
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
        Schema::dropIfExists('t_detail_kta');
    }
}
