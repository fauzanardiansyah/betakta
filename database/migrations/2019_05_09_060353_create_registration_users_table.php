<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_registrasi_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nm_bu');
            $table->string('email_bu');
            $table->string('npwp_bu');
            $table->string('bentuk_bu');
            $table->string('status_bu');
            $table->string('password');
            $table->string('remember_token');
            $table->datetime('email_verified_at')->nullable();
            $table->string('foto_profile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_registrasi_users');
    }
}
