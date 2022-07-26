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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_price_id', 255);
            $table->string('slug', 40);
            $table->string('name', 25);
            $table->text('conditions')->nullable();
            $table->float('price', 6, 2);
            $table->string('currency', 3);
            $table->string('quantity', 5);
            $table->string('people_per_ticket', 4)->default(1);
            $table->foreignId('event_id');
            $table->boolean('visible')->default(0);
            $table->boolean('time_limit')->default(0);
            $table->dateTime('max_datetime')->nullable();
            $table->boolean('id_number_required')->default(true);
            $table->boolean('sold_out')->default(false);
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
        Schema::dropIfExists('tickets');
    }
};
