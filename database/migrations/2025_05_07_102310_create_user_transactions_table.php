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
        Schema::create('user_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('receiver_id')->nullable()->default(null);
            $table->unsignedBigInteger('sender_id')->nullable()->default(null);
            $table->float('amount');
            $table->string('note')->nullable();
            $table->integer('status')->default(0)->comment('0 = pending, 1 = completed');
            $table->integer('type')->default(0)->comment('0 = credit, 1 = debit');

            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_transactions');
    }
};
