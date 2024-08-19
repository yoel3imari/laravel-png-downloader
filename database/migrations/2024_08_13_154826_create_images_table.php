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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // from title + datetime in s
            $table->string('title');
            $table->text('description');
            $table->string('size'); // in Mb
            $table->unsignedInteger('width');
            $table->unsignedInteger('height');
            $table->unsignedInteger('visit_count')->default(0); // increment on show
            $table->unsignedInteger('download_count')->default(0); // increment on download
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
