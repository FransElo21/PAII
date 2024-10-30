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
        Schema::create('pengunjung', function (Blueprint $table) {
            $table->id();
            $table->string('namaLengkap');
            $table->string('foto_profil')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('status_pekerjaan');
            $table->string('jenis_kelamin');
            $table->string('nomor_telepon');
            $table->string('email')->unique();
            $table->string('alamat');
            $table->timestamp('last_login')->nullable();
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
        Schema::dropIfExists('pengunjung');
    }
};
