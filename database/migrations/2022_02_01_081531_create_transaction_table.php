<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('tanggal');
            // $table->string('cid');
            // $table->string('kd');
            // $table->string('produk');
            // $table->string('bank');
            $table->string('rekening');
            $table->string('bulan');
            $table->bigInteger('rptag');
            $table->bigInteger('rpadm');
            $table->bigInteger('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
