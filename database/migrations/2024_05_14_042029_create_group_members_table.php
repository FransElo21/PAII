<?php

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_members', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->default(DB::raw('UUID()'));
            $table->unsignedBigInteger('undangan_id');
            $table->string('name');
            $table->string('nik', 20); // Menggunakan tipe data string dengan panjang maksimal 20 karakter
            $table->string('email');
            $table->string('phone'); 
            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();   
            $table->timestamps();
        
            $table->foreign('undangan_id')->references('id')->on('undangan_pengunjung')->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_members');
    }
};
