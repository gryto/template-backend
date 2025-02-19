<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roles_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('modules_id')->constrained('modules')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('dashboard')->default(false);
            $table->boolean('graph')->default(false);
            $table->boolean('create')->default(false);
            $table->boolean('update')->default(false);
            $table->boolean('delete')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('access');
    }
};
