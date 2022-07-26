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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->string('username', 20);
            $table->string('password');
            $table->foreignId('organization_id');
            $table->foreignId('venue_id')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('master')->default(false);
            $table->string('one_time_token')->nullable();
            $table->datetime('token_datetime');
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
        Schema::dropIfExists('admins');
    }
};
