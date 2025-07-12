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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('Title of the project');
            $table->text('description')->nullable()->comment('Description of the project');
            $table->text('detailed_description')->nullable()->comment('Detailed description of the project');
            $table->json('technologies')->nullable()->comment('Technologies used in the project');
            $table->string('image')->nullable()->comment('Image of the project');
            $table->json('gallery')->nullable()->comment('Gallery of images of the project');
            $table->string('live_url')->nullable()->comment('Live URL of the project');
            $table->string('github_url')->nullable()->comment('GitHub URL of the project');
            $table->string('category')->nullable()->comment('Category of the project (e.g. Web, Mobile, Desktop, etc.)');
            $table->boolean('featured')->default(false)->comment('Is this project featured? 1 = Yes, 0 = No.');
            $table->integer('order')->default(0)->comment('Order of the project in the portfolio');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
