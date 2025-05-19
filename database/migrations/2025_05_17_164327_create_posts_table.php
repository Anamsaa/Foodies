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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Published', 'Deleted', 'Hidden', 'Draft'])->default('Published');
            $table->enum('visibility', ['Public', 'Private', 'Friends'])->default('Public');
            $table->foreignId('photo_id')->nullable()->constrained('photos')->onDelete('set null');
            $table->text('content')->nullable();
            $table->enum('post_type', ['Normal', 'Review', 'Culinary Event']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
