<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'reporting';

    public function up(): void
    {
        Schema::dropIfExists('gadgets');
    }

    public function down(): void
    {
        //
    }
};
