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
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->uuid('recipe_id');
            $table->uuid('ingredient_id');
            $table->primary(['recipe_id', 'ingredient_id']);
        });
    }
};
