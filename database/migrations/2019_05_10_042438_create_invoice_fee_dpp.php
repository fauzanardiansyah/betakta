<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceFeeDpp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_invoice_fee_dpp', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('id_detail_role_share');
            $table->string('no_invoice');
            $table->integer('jml_tagihan_aggt');
            $table->integer('jml_tagihan');
            $table->integer('biaya_trf');
            $table->integer('rate_fee');
            $table->datetime('tgl_cetak');
            $table->integer('status_pembayaran');
            $table->datetime('tgl_byr');
            $table->string('no_trx');
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
        Schema::dropIfExists('t_invoice_fee_dpp');
    }
}
