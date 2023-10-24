<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyConversionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('currency_conversion');

        Schema::create('currency_conversion', function (Blueprint $table) {
            $table->id();
            $table->integer('source_currency_id');
            $table->integer('target_currency_id');
            $table->float('source_currency_value');
            $table->float('target_currency_value');
            $table->timestamps();

            $table->foreign('source_currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('cascade');

            $table->foreign('target_currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_conversion');
    }
}
