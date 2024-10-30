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
        Schema::create('undangan_host', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('keperluan');
            $table->string('kunjungan_dari');
            $table->string('status')->default('Diterima');
            $table->string('keterangan');
            $table->unsignedBigInteger('host_id');
            $table->unsignedBigInteger('lokasi_id');
            $table->timestamp('waktu_temu')->nullable();
            $table->timestamp('waktu_kembali')->nullable();
            $table->timestamps();

            $table->foreign('host_id')->references('id')->on('host')->onDelete('cascade');
            $table->foreign('lokasi_id')->references('id')->on('lokasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('undangan_host');
    }
};
