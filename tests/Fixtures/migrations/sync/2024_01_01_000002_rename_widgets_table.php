<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('widgets', 'renamed_widgets');
    }

    public function down(): void
    {
        Schema::rename('renamed_widgets', 'widgets');
    }
};
