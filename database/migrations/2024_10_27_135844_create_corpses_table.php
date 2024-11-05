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
        Schema::create('corpses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grave_id');
            $table->string('name');
            $table->geography('coordinates')->nullable();
            $table->integer('lat')->nullable();
            $table->integer('lng')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corpses');
    }
};
