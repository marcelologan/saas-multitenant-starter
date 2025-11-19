<?php
// database/seeders/PlansTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $plans = [
            [
                'id' => 1,
                'name' => 'Gratuito',
                'slug' => 'gratuito',
                'description' => 'Plano básico para teste - 30 dias',
                'price' => 0.00,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'api_calls' => 100,
                    'dashboard' => true,
                    'storage_gb' => 1,
                    'basic_reports' => true,
                    'email_support' => false
                ]),
                'max_users' => 2,
                'max_storage_gb' => 1,
                'max_products' => 50,
                'is_active' => true,
                'is_popular' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Ideal para pequenas empresas',
                'price' => 29.90,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'api_calls' => 1000,
                    'dashboard' => true,
                    'storage_gb' => 5,
                    'basic_reports' => true,
                    'email_support' => true,
                    'weekly_backup' => true,
                    'advanced_reports' => false
                ]),
                'max_users' => 5,
                'max_storage_gb' => 5,
                'max_products' => 500,
                'is_active' => true,
                'is_popular' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Para empresas em crescimento',
                'price' => 59.90,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'api_calls' => 5000,
                    'dashboard' => true,
                    'storage_gb' => 20,
                    'daily_backup' => true,
                    'basic_reports' => true,
                    'email_support' => true,
                    'phone_support' => true,
                    'api_integration' => true,
                    'advanced_reports' => true
                ]),
                'max_users' => 15,
                'max_storage_gb' => 20,
                'max_products' => 2000,
                'is_active' => true,
                'is_popular' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Solução completa para grandes empresas',
                'price' => 149.90,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'sso' => true,
                    'api_calls' => 50000,
                    'dashboard' => true,
                    'storage_gb' => 100,
                    'white_label' => true,
                    'daily_backup' => true,
                    'basic_reports' => true,
                    'email_support' => true,
                    'phone_support' => true,
                    'custom_reports' => true,
                    'api_integration' => true,
                    'realtime_backup' => true
                ]),
                'max_users' => 999,
                'max_storage_gb' => 100,
                'max_products' => 999999,
                'is_active' => true,
                'is_popular' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('plans')->insert($plans);
    }
}