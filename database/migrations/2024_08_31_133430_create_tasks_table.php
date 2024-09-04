<?php

use App\Models\Department;
use App\Models\User;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file')->nullable();
            $table->longText('content');
            $table->timestamp('deadline');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('done_at')->nullable();
            $table->string('status')->default('NEW');
            $table->string('priority');
            $table->tinyInteger('speed_rating')->nullable();
            $table->tinyInteger('accuracy_rating')->nullable();
            $table->tinyInteger('quality_rating')->nullable();
            $table->foreignIdFor(User::class)->constrained()->onDelete('no action')->onUpdate('cascade');
            // $table->foreignIdFor(User::class, 'assignee_id')->constrained()->onDelete('no action')->onUpdate('cascade'); manytomany
            $table->foreignIdFor(Department::class)->constrained()->onDelete('no action')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
