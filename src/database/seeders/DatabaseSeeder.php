<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) user 1名作成（ログインできるように固定が便利）
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test1@example.com',
            'password' => Hash::make('password123'),
        ]);

        // 2) weight_target 1件（このuserに紐づく）
        WeightTarget::factory()->create([
            'user_id' => $user->id,
        ]);

        // 3) weight_logs 35件（このuserに紐づく）
        WeightLog::factory()
            ->count(35)
            ->create([
                'user_id' => $user->id,
            ]);
    }
}

