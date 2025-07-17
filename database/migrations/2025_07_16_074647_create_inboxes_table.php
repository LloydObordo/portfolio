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
        Schema::create('inboxes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Full name of the sender');
            $table->string('email')->comment('Email address of the sender');
            $table->string('subject')->nullable()->comment('Subject of the message');
            $table->text('message')->comment('Content of the message');
            $table->boolean('is_read')->default(false)->comment('Indicates if the message has been read');
            $table->timestamp('read_at')->nullable()->comment('Timestamp when the message was read');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inboxes');
    }
};
