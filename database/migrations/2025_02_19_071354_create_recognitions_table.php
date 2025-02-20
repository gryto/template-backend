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
        Schema::create('recognitions', function (Blueprint $table) {
            $table->id();
            $table->enum('mask', ['with_mask', 'without_mask', 'mask_worn_incorrectly', 'mask_worn_correctly'])
                  ->default('without_mask');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->float('similarity')->default(0.97);
            $table->timestamps(); // Laravel akan otomatis mengelola created_at & updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recognitions');
    }
};
