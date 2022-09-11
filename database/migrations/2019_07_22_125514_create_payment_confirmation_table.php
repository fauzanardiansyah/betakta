<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentConfirmationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_payment_confirmation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_invoice_kta')->unsigned();
            $table->string('no_invoice');
            $table->string('nominal');
            $table->string('atas_nama');
            $table->string('nama_bank_anda');
            $table->timestamps();

            $table->foreign('id_invoice_kta')
            ->references('id')
            ->on('t_invoice_kta')
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
        Schema::dropIfExists('t_payment_confirmation');
    }
}
