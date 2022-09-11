<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_app_kta', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('id_detail_kta');
            $table->integer('status_pengajuan');
            $table->datetime('tgl_status');
            $table->text('keterangan', 500);
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
        Schema::dropIfExists('t_app_kta');
    }
}
