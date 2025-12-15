<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        Template::firstOrCreate(
            ['name' => 'Cambodia Standard Operating Template'],
            [
                'version' => 'v1.0',
                'description' => 'Baseline SOP template aligned with Cambodian compliance expectations.',
                'sections_schema' => [
                    ['key' => 'purpose', 'label' => 'Purpose', 'required' => true],
                    ['key' => 'scope', 'label' => 'Scope', 'required' => true],
                    ['key' => 'procedure', 'label' => 'Procedure', 'required' => true],
                    ['key' => 'responsibilities', 'label' => 'Responsibilities', 'required' => true],
                    ['key' => 'references', 'label' => 'References', 'required' => false],
                ],
                'required_metadata' => ['department', 'effective_date', 'governing_regulation'],
                'status' => 'active',
            ]
        );
    }
}
