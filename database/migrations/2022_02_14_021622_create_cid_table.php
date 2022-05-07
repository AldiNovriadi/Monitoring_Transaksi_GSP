<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cid', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cid')->unique();
            $table->string('nama_cid');
            $table->string('filetemplate')->nullable();
            $table->string('jenis')->nullable();
            $table->foreignId('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('bank')->onDelete('set null');
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('cid');
    }
}
