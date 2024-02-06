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
        Schema::create('spotlight_values', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('route');
            $table->string('icon')->nullable();
            $table->boolean('admin')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spotlight_values');
    }
};
