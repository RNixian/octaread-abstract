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
        Schema::table('userdepartment', function (Blueprint $table) {
            $table->renameColumn('programplus', 'user_department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('userdepartment', function (Blueprint $table) {
            $table->renameColumn('user_department', 'programplus');
        });
    }
};
