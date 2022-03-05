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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('order_id');
            $table->string('payment_no', 255);
            $table->double('payed', 8, 2);
            $table->double('balance', 8, 2);
            $table->foreignId('payment_mode_id');
            $table->string('payment_evidence', 255)->nullable();
            $table->boolean('success');
            $table->boolean('confirmed')->nullable();
            $table->integer('confirmed_by');
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
        Schema::dropIfExists('payments');
    }
};
