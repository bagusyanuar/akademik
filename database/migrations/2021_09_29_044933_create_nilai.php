<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pelajaran_kelas_id')->unsigned()->nullable(false);
            $table->bigInteger('siswa_id')->unsigned()->nullable(false);
            $table->float('nilai')->default(0);
            $table->foreign('pelajaran_kelas_id')->references('id')->on('pelajaran_kelas');
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
        Schema::dropIfExists('nilai');
    }
}
