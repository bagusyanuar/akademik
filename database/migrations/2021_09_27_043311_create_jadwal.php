<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periode_id')->unsigned();
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu']);
            $table->bigInteger('kelas_id')->unsigned();
            $table->bigInteger('mata_pelajaran_id')->unsigned();
            $table->foreign('periode_id')->references('id')->on('periode');
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->foreign('mata_pelajaran_id')->references('id')->on('mata_pelajaran');
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
        Schema::dropIfExists('jadwal');
    }
}
