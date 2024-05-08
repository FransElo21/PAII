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
        Schema::create('detail_undangan_host', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('undangan_id');
            $table->unsignedBigInteger('register_id')->nullable(); // ID pengunjung terdaftar
            $table->unsignedBigInteger('non_register_id')->nullable(); // ID pengunjung tidak terdaftar
            $table->boolean('is_terdaftar'); // untuk menandai apakah pengunjung terdaftar atau tidak
            $table->timestamps();
        
            $table->foreign('undangan_id')->references('id')->on('undangan_host')->onDelete('cascade');
            $table->foreign('register_id')->references('id')->on('pengunjung_register_terundang')->onDelete('cascade');
            $table->foreign('non_register_id')->references('id')->on('pengunjung_nonregister_terundang')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_undangan_hosts');
    }
};
