<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('user_transaction_id')->nullable();
            $table->foreign('user_transaction_id')->references('id')->on('user_transactions')->onDelete('cascade')->onUpdate('cascade');

            $table->string('amount')->nullable();
            $table->string('currency')->nullable();

            $table->string('status')->nullable()->default(0)->comment('0 = pending, 1 = completed, 2 = failed, 3 = cancelled');

            $table->string('payment_method')->nullable()->default(0)->comment('0 = sslcommerz, 1 = manual');
            $table->string('payment_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payments');
    }
};
