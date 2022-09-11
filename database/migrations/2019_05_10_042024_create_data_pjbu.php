<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataPjbu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pj_kta', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('id_detail_kta');
            $table->string('nm_pjbu', 50);
            $table->string('kewarganegaraan', 3);
            $table->string('nik', 20)->nullable();
            $table->string('no_passport', 20)->nullable();
            $table->string('jabatan', 15);
            $table->string('pendidikan', 10);
            $table->string('tempat');
            $table->string('tgl_lahir');
            $table->text('alamat');
            $table->string('email_pjbu', 30);
            $table->string('npwp_pjbu', 15);
            $table->string('no_hp_pjbu');
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
        Schema::dropIfExists('t_pj_kta');
    }
}
