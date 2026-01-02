<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();

            // TMDB person ID
            $table->unsignedBigInteger('tmdb_id')->unique();

            $table->string('name');
            $table->string('profile_path')->nullable();
            $table->string('known_for_department')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};