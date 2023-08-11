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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 11, 2);
            $table->smallInteger('day')->default(1);
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('debt_id')->nullable();
            $table->ulid('subscription_id')->nullable();
            $table->ulid('card_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('debt_id')->references('id')->on('debts');
            $table->foreign('subscription_id')->references('id')->on('subscriptions');
            $table->foreign('card_id')->references('id')->on('cards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
