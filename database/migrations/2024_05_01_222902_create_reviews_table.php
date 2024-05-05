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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('summarize');
            $table->float('positivity');
            $table->float('negativity');
            $table->string('url')->nullable();
            $table->float('stars');
            $table->string('date');
            $table->json('images')->nullable();
            $table->unsignedBigInteger('product_id')
                ->constrained()
                ->onUpdate('cascade')   
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
