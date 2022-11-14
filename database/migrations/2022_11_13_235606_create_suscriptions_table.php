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
        Schema::create('suscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount', 11, 2)->default(0.0);
            $table->smallInteger('day')->default(1);
            $table->smallInteger('month')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('external_id');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('external_id')->references('id')->on('externals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suscriptions');
    }
};
