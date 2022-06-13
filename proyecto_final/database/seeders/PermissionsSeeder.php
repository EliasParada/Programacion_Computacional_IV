<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('permissions')->insert([
            [
                'name' => 'Usuario Común',
                'description' => 'Solo permiso para usuarios comunes',
            ],
            [
                'name' => 'Usuario Experto',
                'description' => 'Solo permiso para usuarios expertos',
            ],
        ]);
    }
}
