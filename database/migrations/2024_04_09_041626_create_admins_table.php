<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('Nama');
            $table->string('username');
            $table->string('password');
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin');
    }
};

