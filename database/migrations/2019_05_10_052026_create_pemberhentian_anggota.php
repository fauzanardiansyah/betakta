<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemberhentianAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pemberhentian_agt', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('id_detail_kta');
            $table->string('file_pemberhentian');
            $table->string('keterangan');
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
        Schema::dropIfExists('pemberhentian_anggota');
    }
}
