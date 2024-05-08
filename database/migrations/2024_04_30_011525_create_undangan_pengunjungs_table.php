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
        Schema::create('undangan_pengunjung', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('keterangan');
            $table->string('status')->default('Menunggu');
            $table->timestamp('waktu_temu')->nullable();
            $table->timestamp('waktu_kembali')->nullable();
            $table->unsignedBigInteger('lokasi_id')->nullable();
            $table->unsignedBigInteger('host_id');
            $table->unsignedBigInteger('pengunjung_id');
            $table->timestamps();
        
            $table->foreign('lokasi_id')->references('id')->on('lokasi')->onDelete('cascade');
            $table->foreign('host_id')->references('id')->on('host')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('undangan_pengunjung');
    }
};
