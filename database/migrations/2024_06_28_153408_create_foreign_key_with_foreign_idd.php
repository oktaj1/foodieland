<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            // $table->text('ingredients'); // Uncomment if needed
            $table->text('instructions');
            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }
};
