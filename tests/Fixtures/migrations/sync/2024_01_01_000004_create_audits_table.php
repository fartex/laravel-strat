<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = config('audit.drivers.database.connection', config('database.default'));

        Schema::connection($connection)->create('audits', function (Blueprint $table) {
            $table->id();
        });
    }

    public function down(): void
    {
        //
    }
};
