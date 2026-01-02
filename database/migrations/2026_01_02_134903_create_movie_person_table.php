<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movie_person', function (Blueprint $table) {
            $table->id();

            $table->foreignId('movie_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('person_id')
                ->constrained('people')
                ->cascadeOnDelete();

            // Cast / crew metadata
            $table->string('character')->nullable(); // cast
            $table->string('job')->nullable();       // crew
            $table->unsignedInteger('order')->nullable();

            $table->timestamps();

            // Prevent duplicate credits
            $table->unique([
                'movie_id',
                'person_id',
                'character',
                'job'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_person');
    }
};