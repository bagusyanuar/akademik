<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSemesterJadwal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->enum('semester', [1, 2])->default(1)->nullable(false)->after('periode_id');
            $table->time('mulai')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'))->nullable(false)->after('mata_pelajaran_id');
            $table->time('selesai')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'))->nullable(false)->after('mulai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn('semester');
            $table->dropColumn('mulai');
            $table->dropColumn('selesai');
        });
    }
}
