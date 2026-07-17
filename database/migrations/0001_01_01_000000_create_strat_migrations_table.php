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
        Schema::create('strat_migrations', function (Blueprint $table) {
            $table->id();
            $table->string('migration')->unique();
            $table->string('table');
            $table->string('connection');
            $table->string('type');
            $table->string('status');
            $table->unsignedInteger('batch')->nullable();
            $table->timestamp('executed_at')->nullable();
            $table->unsignedInteger('duration_ms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strat_migrations');
    }
};
