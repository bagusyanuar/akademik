<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAbse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absen_siswa', function (Blueprint $table) {
            $table->dropForeign('absen_siswa_siswa_id_foreign');
            $table->dropColumn('siswa_id');
            $table->bigInteger('kelas_siswa_id')->unsigned()->after('absen_id');
            $table->foreign('kelas_siswa_id')->references('id')->on('kelas_siswa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absen_siswa', function (Blueprint $table) {
            //
        });
    }
}
