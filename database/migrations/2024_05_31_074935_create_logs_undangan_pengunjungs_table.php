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
        Schema::create('logs_undangan_pengunjung', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('undangan_id');
            $table->unsignedBigInteger('pengunjung_id');
            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();
            $table->timestamps();

            $table->foreign('undangan_id')->references('id')->on('undangan_pengunjung')->onDelete('cascade');
            $table->foreign('pengunjung_id')->references('id')->on('pengunjung')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs_undangan_pengunjung');
    }
};
