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
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('certification_title')->comment('Title of the certification.');
            $table->string('organization')->comment('Name of the organization that issued the certification.');
            $table->string('location')->nullable()->comment('Location of the organization that issued the certification.');
            $table->date('date_issued')->nullable()->comment('Date the certification was issued.');
            $table->date('date_expired')->nullable()->comment('Date the certification expires.');
            $table->text('description')->nullable()->comment('Description of the certification.');
            $table->string('organiozation_logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
