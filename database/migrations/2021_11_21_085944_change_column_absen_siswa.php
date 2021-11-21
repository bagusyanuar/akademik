<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnAbsenSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absen_siswa', function(Blueprint $table) {
            $table->dropColumn('semester');
        });

        Schema::table('absen_siswa', function(Blueprint $table) {
            $table->enum('nilai', ['masuk', 'ijin', 'alpha'])->default('alpha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
