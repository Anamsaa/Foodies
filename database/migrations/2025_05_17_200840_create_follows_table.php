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
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower_id')->constrained('profiles')->onDelete('cascade');
            $table->foreignId('followed_id')->constrained('profiles')->onDelete('cascade');
            // Si un usuario hace click a seguir se crea el registro en esta tabla, por eso el estado por defecto es: "Following"
            $table->enum('status', ['Following', 'Pending', 'Unfollowed'])->default('Following');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
