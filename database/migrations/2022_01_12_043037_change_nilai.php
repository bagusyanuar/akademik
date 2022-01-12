<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNilai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropForeign('nilai_siswa_id_foreign');
            $table->dropColumn('siswa_id');
            $table->bigInteger('kelas_siswa_id')->unsigned()->after('pelajaran_kelas_id');
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
        Schema::table('nilai', function (Blueprint $table) {
            //
        });
    }
}
