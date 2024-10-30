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
    Schema::create('pengunjung_undangan_host', function (Blueprint $table) {
        $table->uuid('uuid')->primary()->default(DB::raw('UUID()'));
        $table->string('name');
        $table->string('email');
        $table->string('phone');
        $table->string('NIK');
        $table->timestamp('check_in')->nullable();
        $table->timestamp('check_out')->nullable();
        $table->timestamps();

        // Tambahkan kolom foreign key
        $table->unsignedBigInteger('undangan_id');
        $table->foreign('undangan_id')->references('id')->on('undangan_host')->onDelete('cascade');
    });


    }

    /**
     * Set default value for UUID column.
     *
     * @param string $tableName
     * @param string $columnName
     * @return void
     */
    protected function setUuidDefaultValue($tableName, $columnName)
    {
        // Generate UUID using PHP function
        $uuid = $this->generateUuid();

        // Set default value for uuid column
        DB::statement("ALTER TABLE $tableName ALTER COLUMN $columnName SET DEFAULT '$uuid'");
    }

    /**
     * Generate UUID.
     *
     * @return string
     */
    protected function generateUuid()
    {
        // Generate UUID using PHP function
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengunjung_undangan_host');
    }
};
