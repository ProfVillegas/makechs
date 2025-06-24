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
        Schema::create('authors', function (Blueprint $table) {            
            $table->id();
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('slastname');
            $table->string('equis');
            $table->string('instagram');
            $table->string('tiktok');
            $table->string('youtube');
            $table->string('website');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
