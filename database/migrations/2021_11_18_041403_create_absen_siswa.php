<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen_siswa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('absen_id')->unsigned();
            $table->bigInteger('siswa_id')->unsigned();
            $table->enum('semester', ['masuk', 'ijin', 'alpha'])->default('masuk')->nullable(false);
            $table->text('keterangan');
            $table->foreign('absen_id')->references('id')->on('absen');
            $table->foreign('siswa_id')->references('id')->on('siswa');
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
        Schema::dropIfExists('absen_siswa');
    }
}
