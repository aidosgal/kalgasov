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
        Schema::create("stores", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->longText("name");
            $table->longText("description");
            $table->string("city");
            $table->string("phone")->nullable();
            $table->string("link1")->nullable();
            $table->string("link2")->nullable();
            $table->string("link3")->nullable();
            $table->string("avatar_url")->nullable();
            $table->string("background_url")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("stores");
    }
};
