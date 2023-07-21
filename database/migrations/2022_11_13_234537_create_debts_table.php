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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount', 11, 2)->default(0.0);
            $table->decimal('fee_value', 11, 2)->default(0.0);
            $table->smallInteger('fee_day')->default(1);
            $table->smallInteger('fee_number')->default(1);
            $table->smallInteger('fee_current')->default(0);
            $table->smallInteger('status')->default(1);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('external_id')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('external_id')->references('id')->on('externals');
            $table->foreign('bank_id')->references('id')->on('banks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debts');
    }
};
