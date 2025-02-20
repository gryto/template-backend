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
        Schema::create('layouts', function (Blueprint $table) {
            $table->id();
            $table->text('app_name');
            $table->text('short_app_name');
            $table->boolean('header')->default(true);
            $table->boolean('footer')->default(true);
            $table->boolean('fullscreen')->default(true);
            $table->boolean('face_recognition')->default(true);
            $table->text('icon')->nullable();
            $table->text('img_login_bg')->nullable();
            $table->enum('login_position', ['left', 'center', 'right'])->default('left');
            $table->timestamps(); // Ini lebih baik daripada setting manual `created_at` & `updated_at`
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layouts');
    }
};
