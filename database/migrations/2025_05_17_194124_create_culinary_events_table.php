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
        Schema::create('culinary_events', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->primary();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade'); 
            $table->string('title');
            $table->date('event_date');
            $table->time('event_time');
            $table->enum('status', ['Ongoing', 'Completed', 'Deleted'])->default('Ongoing');
            $table->integer('max_participants');
            $table->text('short_description')->nullable();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('culinary_events');
    }
};
