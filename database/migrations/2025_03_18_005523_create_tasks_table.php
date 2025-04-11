<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('due_date');
            $table->string('status', 50)->default('todo'); // todo, in_progress, completed
            $table->string('priority', 50)->default('medium'); // low, medium, high
            $table->string('label', 50)->nullable();
            $table->timestamps();
            
            // Add indexes for PostgreSQL performance
            $table->index('due_date');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};