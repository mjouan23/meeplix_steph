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
        Schema::create('boardgame_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boardgame_id')->constrained()->onDelete('cascade');
            $table->string('display_name');
            $table->string('file_path');
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boardgame_files');
    }
};
