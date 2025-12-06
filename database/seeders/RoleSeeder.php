<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ Add this

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'super', 'label' => 'Super Admin'],
            ['id' => 2, 'name' => 'user',  'label' => 'Normal User'],
        ]);
    }
}
