<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cogs');
            $table->foreign('cogs')->references('id')->on('accounts');
            $table->unsignedBigInteger('shipping_fee')->nullable();
            $table->foreign('shipping_fee')->references('id')->on('accounts');
            $table->unsignedBigInteger('discount')->nullable();
            $table->foreign('discount')->references('id')->on('accounts');
            $table->unsignedBigInteger('tax_vax')->nullable();
            $table->foreign('tax_vax')->references('id')->on('accounts');
            $table->unsignedBigInteger('round_of')->nullable();
            $table->foreign('round_of')->references('id')->on('accounts');
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
        Schema::dropIfExists('sale_settings');
    }
}
