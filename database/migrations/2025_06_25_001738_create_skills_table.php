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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Name of the skill (e.g. HTML, CSS, JavaScript, etc.)');
            $table->string('category')->nullable()->comment('Category of the skill (e.g. Technical, Soft, Tools)'); // technical, soft, tools
            $table->integer('proficiency')->default(0)->comment('Proficiency level of the skill (e.g. 1-100)'); // 1-100
            $table->string('icon')->nullable()->comment('Icon of the skill');
            $table->integer('order')->default(0)->comment('Order of the skill in the list');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
