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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('slug_code', 40);
            $table->foreignId('ticket_id');
            $table->foreignId('user_id');
            $table->float('price', 6, 2);
            $table->string('currency');
            $table->string('recipient_id_number', 10)->nullable();
            $table->string('recipient_email', 320)->nullable();
            $table->string('recipient_phone', 25)->nullable();
            $table->string('recipient_gender', 2)->nullable();
            $table->string('stripe_transaction_id', 255); 
            $table->boolean('selling')->default(false);
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
        Schema::dropIfExists('purchases');
    }
};
