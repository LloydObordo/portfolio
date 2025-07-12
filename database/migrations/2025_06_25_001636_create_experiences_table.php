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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('job_title')->comment('Job title at the company or organization you worked for.');
            $table->string('company')->comment('Name of the company or organization you worked for.');
            $table->string('location')->nullable()->comment('Location of the company or organization you worked for.');
            $table->date('start_date')->nullable()->comment('Start date of your work experience.');
            $table->date('end_date')->nullable()->comment('End date of your work experience.');
            $table->boolean('is_current')->default(false)->comment('Is this your current work experience? 1 = Yes, 0 = No.');
            $table->text('description')->nullable()->comment('Description of your work experience.');
            $table->json('achievements')->nullable();
            $table->string('company_logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
