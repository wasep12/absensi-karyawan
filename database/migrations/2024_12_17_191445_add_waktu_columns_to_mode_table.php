<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaktuColumnsToModeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mode', function (Blueprint $table) {
            $table->id();
            $table->integer('mode');
            $table->time('waktu_masuk');
            $table->time('waktu_pulang');
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
        Schema::table('mode', function (Blueprint $table) {
            $table->dropColumn(['waktu_masuk', 'waktu_pulang']);
        });
    }
}