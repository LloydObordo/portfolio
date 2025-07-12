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
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->string('institution')->nullable()->comment('Name of the educational institution.');
            $table->enum('degree', ['bachelor', 'master', 'doctorate', 'associate'])->nullable()->comment('Degree earned, e.g. Bachelor\'s, Master\'s, etc.');
            $table->string('field_of_study')->nullable()->comment('Field of study, e.g. Computer Science, Psychology, etc.');
            $table->date('start_date')->nullable()->comment('Start date of education.');
            $table->date('end_date')->nullable()->comment('End date of education.');
            $table->boolean('is_current')->default(false)->comment('Is this your current education? 1 = Yes, 0 = No.');
            $table->text('description')->nullable()->comment('Description of education.');
            $table->integer('order')->default(0)->comment('Order of education in the list.');
            $table->boolean('active')->default(true)->comment('Is this education currently active? 1 = Yes, 0 = No.');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
