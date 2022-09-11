<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_invoice_kta', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('id_detail_kta');
            $table->string('no_invoice');
            $table->integer('jenis_pengajuan');
            $table->integer('jml_tagihan');
            $table->datetime('tgl_cetak');
            $table->integer('status_pembayaran');
            $table->datetime('tgl_bayar')->nullable();
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
        Schema::dropIfExists('t_invoice_kta');
    }
}
