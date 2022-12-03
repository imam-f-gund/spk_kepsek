<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_kepsek', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_indikator');
            $table->foreign('id_indikator')->references('id')->on('indikator')->onDelete('cascade');
            $table->unsignedBigInteger('id_periode');
            $table->foreign('id_periode')->references('id')->on('periode')->onDelete('cascade');
            $table->unsignedBigInteger('id_kepala_sekolah');
            $table->foreign('id_kepala_sekolah')->references('id')->on('kepala_sekolah')->onDelete('cascade');
            $table->float('nilai')->nullable();
            $table->integer('rangking')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_kepsek');
    }
};
