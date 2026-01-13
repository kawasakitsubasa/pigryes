<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weight_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date'); // 日付
            $table->decimal('weight', 5, 1); // 体重
            $table->unsignedInteger('calories'); // 食事摂取カロリー
            $table->unsignedInteger('exercise_minutes'); // 運動時間(分)
            $table->timestamps();

            $table->index(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weight_logs');
    }
};

