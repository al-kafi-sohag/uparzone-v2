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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('referer_id')->nullable();
            $table->foreign('referer_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('reference_code')->nullable();

            $table->string('phone')->nullable();
            $table->string('lang')->default('en');

            $table->float('balance', 2)->default(0);
            $table->boolean('balance_privacy')->default(false);

            $table->float('reserved_balance', 2)->default(0);
            $table->float('freeze_balance', 2)->default(0);

            $table->float('spent_time', 2)->default(0);
            $table->boolean('spent_time_privacy')->default(false);

            $table->boolean('is_premium')->default(false);
            $table->boolean('is_complete_profile')->default(false);

            $table->float('age')->nullable();
            $table->boolean('age_privacy')->default(false);

            $table->string('profession')->nullable();
            $table->boolean('profession_privacy')->default(false);

            $table->text('address')->nullable();
            $table->boolean('address_privacy')->default(false);

            $table->string('city')->nullable();
            $table->boolean('city_privacy')->default(false);

            $table->string('state')->nullable();
            $table->boolean('state_privacy')->default(false);

            $table->string('country')->nullable();
            $table->boolean('country_privacy')->default(false);

            $table->string('zip_code')->nullable();
            $table->boolean('zip_code_privacy')->default(false);

            $table->string('gender')->nullable();
            $table->boolean('gender_privacy')->default(false);

            $table->unsignedBigInteger('mood_id')->nullable();
            $table->boolean('mood_privacy')->default(false);
            $table->foreign('mood_id')->references('id')->on('moods')->onDelete('cascade');

            $table->unsignedBigInteger('religion_id')->nullable();
            $table->boolean('religion_privacy')->default(false);
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('cascade');

            $table->tinyInteger('status')->default(1)->comment('1=Active, 0=Inactive, -1=Banned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referer_id']);
            $table->dropIndex(['referer_id']);
            $table->dropColumn('referer_id');
            $table->dropColumn('phone');
            $table->dropColumn('balance');
            $table->dropColumn('reserved_balance');
            $table->dropColumn('freeze_balance');
            $table->dropColumn('spent_time');
            $table->dropColumn('is_premium');
            $table->dropColumn('is_complete_profile');
            $table->dropColumn('age');
            $table->dropColumn('profession');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('zip_code');
            $table->dropColumn('gender');
            $table->dropColumn('mood_id');
            $table->dropColumn('religion_id');
            $table->dropColumn('balance_privacy');
            $table->dropColumn('spent_time_privacy');
            $table->dropColumn('age_privacy');
            $table->dropColumn('profession_privacy');
            $table->dropColumn('address_privacy');
            $table->dropColumn('city_privacy');
            $table->dropColumn('state_privacy');
            $table->dropColumn('country_privacy');
            $table->dropColumn('zip_code_privacy');
            $table->dropColumn('gender_privacy');
            $table->dropColumn('mood_privacy');
            $table->dropColumn('religion_privacy');
            $table->dropColumn('status');
        });
    }
};
