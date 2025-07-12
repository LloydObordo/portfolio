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
        Schema::table('professional_summaries', function (Blueprint $table) {
            $table->string('firstname')->nullable()->after('id')->comment('First name');
            $table->string('middlename')->nullable()->after('firstname')->comment('Middle name');
            $table->string('lastname')->nullable()->after('middlename')->comment('Last name');
            $table->string('qualifier')->nullable()->after('lastname')->comment('Qualifier (e.g. Jr., Sr., etc.)');
            $table->string('shortname')->nullable()->after('qualifier')->comment('Short name');
            $table->longText('biography')->nullable()->after('shortname')->comment('Biography');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professional_summaries', function (Blueprint $table) {
            $table->dropColumn('firstname');
            $table->dropColumn('middlename');
            $table->dropColumn('lastname');
            $table->dropColumn('qualifier');
            $table->dropColumn('shortname');
            $table->dropColumn('biography');
        });
    }
};
