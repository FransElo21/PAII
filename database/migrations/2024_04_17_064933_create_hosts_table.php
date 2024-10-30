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
        Schema::create('host', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            $table->unsignedBigInteger('divisi_id'); 
            $table->unsignedBigInteger('lokasi_id'); // Ubah menjadi divisi_id dan tambahkan foreign key
            $table->string('username')->unique();
            $table->string('password');
            $table->string('jenis_kelamin');
            $table->bigInteger('nomor_telepon');
            $table->string('email')->unique();
            $table->string('foto_profil')->nullable();
            $table->timestamp('last_login')->nullable(); 
            $table->timestamps();

            $table->foreign('divisi_id')->references('id')->on('divisi')->onDelete('cascade');
            $table->foreign('lokasi_id')->references('id')->on('lokasi')->onDelete('cascade'); // Tambahkan foreign key
        });
                
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('host');
    }
};
