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
        Schema::create('vn_pays', function (Blueprint $table) {
            $table->id();
            $table->string('vnp_Amount');
            $table->string('vnp_BankCode');
            $table->string('vnp_BankTranNo');
            $table->string('vnp_OrderInfo');
            $table->string('vnp_ResponseCode');
            $table->string('vnp_TransactionStatus');
            $table->string('vnp_TxnRef');
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
        Schema::dropIfExists('vn_pays');
    }
};
