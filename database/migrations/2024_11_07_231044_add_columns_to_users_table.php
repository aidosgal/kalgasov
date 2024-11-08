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
        Schema::table("users", function (Blueprint $table) {
            $table->string("last_name")->nullable();
            $table->string("city")->nullable();
            $table->date("date_of_birth")->nullable();
            $table->boolean("show_date_of_birth")->default(false);
            $table->timestamp("subsribed_until")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            //
        });
    }
};
