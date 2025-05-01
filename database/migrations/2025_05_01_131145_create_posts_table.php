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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->unsignedBigInteger('post_category_id');
            $table->foreign('post_category_id')->references('id')->on('post_categories')->cascadeOnDelete();

            $table->unsignedBigInteger('mood_id');
            $table->foreign('mood_id')->references('id')->on('moods')->cascadeOnDelete();

            $table->unsignedBigInteger('religion_id');
            $table->foreign('religion_id')->references('id')->on('religions')->cascadeOnDelete();

            $table->unsignedBigInteger('gender_id');
            $table->foreign('gender_id')->references('id')->on('genders')->cascadeOnDelete();

            $table->boolean('is_adult')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_featured')->default(false);

            $table->integer('views')->default(0);
            $table->integer('reactions')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('comments')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
