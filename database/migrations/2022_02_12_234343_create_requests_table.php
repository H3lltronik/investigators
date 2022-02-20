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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->nullable()->default('');
            $table->string('city')->nullable()->default('');
            $table->string('phone')->nullable()->default('');
            $table->string('status')->nullable()->default('');
            $table->string('address')->nullable()->default('');
            $table->text('notes')->nullable();
            $table->foreignId('financial_id')->references('id')->on('financials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
