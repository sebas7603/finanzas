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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('financial_id');
            $table->decimal('amount', 11, 2)->default(0.0);
            $table->string('description');
            $table->boolean('income')->default(true);
            $table->datetime('date');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('movement_type_id');
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->unsignedBigInteger('external_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->foreign('financial_id')->references('id')->on('financials');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('movement_type_id')->references('id')->on('movement_types');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('external_id')->references('id')->on('externals');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
};
