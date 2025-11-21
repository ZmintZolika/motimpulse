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
        Schema::create('day_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->unsignedTinyInteger('mood');
            $table->enum('weather', ['Napos', 'Felhos', 'Esos', 'Szeles', 'Havas'])->nullable();
            $table->enum('sleep_quality', ['Nagyon rossz', 'Rossz', 'Kozepes', 'Jo', 'Kivalo'])->nullable();
            $table->enum('activity', ['Munka', 'Tanulas', 'Pihenes', 'Sport', 'Szorakozas', 'Egyeb'])->nullable();
            $table->enum('health_action', ['Mozgas', 'Egeszseges etkezes', 'Pihenes', 'Semmi'])->nullable();
            $table->unsignedTinyInteger('score')->nullable();
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->unique(['user_id', 'date']);
            $table->index('mood');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_entries');
    }
};
