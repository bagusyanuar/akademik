<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('periode_id')->unsigned();
            $table->bigInteger('kelas_id')->unsigned();
            $table->enum('semester', [1, 2])->default(1)->nullable(false);
            $table->date('tanggal')->nullable(false);
            $table->foreign('periode_id')->references('id')->on('periode');
            $table->foreign('kelas_id')->references('id')->on('kelas');
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
        Schema::dropIfExists('absen');
    }
}
