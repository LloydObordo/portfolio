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
        Schema::create('professional_summaries', function (Blueprint $table) {
            $table->id();
            $table->text('summary')->nullable()->comment('Professional summary');
            $table->string('resume')->nullable()->comment('Resume file');
            $table->string('cv')->nullable()->comment('CV file');
            $table->string('profile_image')->nullable()->comment('Profile image');
            $table->string('cover_image')->nullable()->comment('Cover image');
            $table->string('address')->nullable()->comment('Address');
            $table->string('phone')->nullable()->comment('Phone number');
            $table->string('email')->nullable()->comment('Email address');
            $table->string('website')->nullable()->comment('Website');
            $table->string('linkedin')->nullable()->comment('LinkedIn profile');
            $table->string('github')->nullable()->comment('GitHub profile');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_summaries');
    }
};
