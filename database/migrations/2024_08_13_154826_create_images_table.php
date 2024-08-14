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
            $table->string('dim'); // w x h
            $table->integer('visits')->default(0); // increment on show
            $table->integer('downloads')->default(0); // increment on download
            $table->foreignId('category_id')->references('categories')->cascadeOnDelete();
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
