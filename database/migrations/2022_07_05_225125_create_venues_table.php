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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 40);
            $table->string('name', 25);
            $table->string('description', 400);
            $table->text('meta_data');
            $table->boolean('visible')->default(0);
            $table->string('latitude', 60);
            $table->string('longitude', 60);
            $table->text('address');
            $table->string('timezone', 60);
            $table->string('currency', 3);
            $table->string('rating', 10)->default(0);
            $table->foreignId('organization_id');
            $table->text('logo_url');
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
        Schema::dropIfExists('venues');
    }
};
