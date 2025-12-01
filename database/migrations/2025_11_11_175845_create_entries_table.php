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
        Schema::create('entries', function (Blueprint $table) {
        $table->id('entry_id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('quote_id')->nullable();
        $table->enum('mood', ['Lehangolt', 'Kiegyensúlyozott', 'Vidám'])->nullable();
        $table->enum('weather', ['Napos', 'Felhős', 'Esős', 'Szeles', 'Havas']);
        $table->enum('sleep_quality', ['Nagyon rossz', 'Rossz', 'Közepes', 'Jó', 'Kiváló']);
        $table->enum('activities', ['Munka', 'Tanulás', 'Pihenés', 'Sport', 'Szórakozás', 'Egyéb']);
        $table->enum('health_action', ['Mozgás', 'Egészséges táplálkozás', 'Pihenés', 'Semmi']);
        $table->text('note')->nullable();
        $table->boolean('is_deleted')->default(false);
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
        $table->timestamp('deleted_at')->nullable();

        $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        $table->foreign('quote_id')->references('quote_id')->on('quotes')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
