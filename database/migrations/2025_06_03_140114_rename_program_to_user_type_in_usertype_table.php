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
        Schema::table('usertype', function (Blueprint $table) {
            $table->renameColumn('program', 'user_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usertype', function (Blueprint $table) {
            $table->renameColumn('user_type', 'program');
        });
    }
};
