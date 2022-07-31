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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_product_id', 255);
            $table->string('slug', 40);
            $table->string('name', 100);
            $table->string('description', 6000);
            $table->text('tags')->nullable();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('max_capacity', 5);
            $table->boolean('visible')->default(true);
            $table->boolean('recurrente')->default(0);
            $table->string('patron_recurrencia')->nullable();
            $table->foreignId('organization_id');
            $table->foreignId('venue_id');
            $table->string('color');
            $table->string('minimum_age', 2)->nullable();
            $table->boolean('sold_out')->default(false);
            $table->text('poster_url')->nullable();
            $table->boolean('meta_event')->default(false);
            $table->foreignId('original_event_id')->nullable();
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
        Schema::dropIfExists('events');
    }
};
