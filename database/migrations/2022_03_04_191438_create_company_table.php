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
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('about');
            $table->string('email', 255);
            $table->text('phone_numbers');
            $table->string('address', 255);
            $table->text('return_policy')->nullable();
            $table->text('delivery_policy')->nullable();
            $table->text('faq')->nullable();
            $table->timestamps();
        });
        \Artisan::call('db:seed', array('--class' => 'CompanySeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
};
