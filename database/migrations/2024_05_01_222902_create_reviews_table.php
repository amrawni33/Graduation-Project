<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
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
            $table->dateTime('date');
            $table->json('images')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
}
