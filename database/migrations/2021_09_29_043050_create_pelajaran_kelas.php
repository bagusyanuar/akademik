<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelajaranKelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelajaran_kelas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periode_id')->unsigned();
            $table->bigInteger('kelas_id')->unsigned();
            $table->bigInteger('mata_pelajaran_id')->unsigned();
            $table->enum('semester', [1, 2])->default(1)->nullable(false);
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
        Schema::dropIfExists('pelajaran_kelas');
    }
}
