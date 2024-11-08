<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("reviews", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("product_id")->nullable();
            $table->foreignId("store_id")->nullable();
            $table->integer("grade");
            $table->longText("review")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("reviews");
    }
};