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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('card_type_id');
            $table->decimal('quota', 11, 2)->default(0.0);
            $table->decimal('amount', 11, 2)->default(0.0);
            $table->decimal('fee', 11, 2)->default(0.0);
            $table->smallInteger('balance_day')->default(1);
            $table->smallInteger('payment_day')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('card_type_id')->references('id')->on('card_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
};
