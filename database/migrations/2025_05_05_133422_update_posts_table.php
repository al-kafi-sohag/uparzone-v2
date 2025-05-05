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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('content')->nullable()->change();
            $table->unsignedBigInteger('post_category_id')->nullable()->change();
            $table->unsignedBigInteger('mood_id')->nullable()->change();
            $table->unsignedBigInteger('religion_id')->nullable()->change();
            $table->unsignedBigInteger('gender_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
