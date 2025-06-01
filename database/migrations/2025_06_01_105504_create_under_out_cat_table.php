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
        Schema::create('under_out_cat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('out_cat_id');
            $table->string('under_roc');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('out_cat_id')->references('id')->on('research_out_cat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('under_out_cat');
    }
};
