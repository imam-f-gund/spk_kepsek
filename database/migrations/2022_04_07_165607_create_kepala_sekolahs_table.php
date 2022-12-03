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
        Schema::create('kepala_sekolah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sekolah');
            $table->foreign('id_sekolah')->references('id')->on('sekolah')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->text('alamat')->nullable();
            $table->string('no_telp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kepala_sekolah');
    }
};
