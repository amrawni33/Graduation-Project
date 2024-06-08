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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->string('url')->unique();
            $table->text('short_description');
            $table->string('image'); // Store images as JSON array
            $table->float('average_rating');
            $table->integer('total_reviews')->default(0);
            $table->string('seller_name');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('website_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
