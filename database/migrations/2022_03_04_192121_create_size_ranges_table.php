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
        Schema::create('size_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('size_id');
            $table->foreignId('size_type_id');
            $table->double('min', 8, 2);
            $table->double('max', 8, 2);
            $table->timestamps();
        });
        \Artisan::call('db:seed', array('--class' => 'SizeRangeSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('size_ranges');
    }
};
