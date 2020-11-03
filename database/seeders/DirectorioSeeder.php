<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DirectorioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('directorios')->insert([
            [
                'name'=>'Carlos Luna',
                'direction'=>'Los Robles, Maneiro, Nueva Esparta',
                'phone'=>'04166964462',
                'email'=>'carlos@gmail.com',
                
            ],
            [
                'name'=>'Andrea Luna',
                'direction'=>'Los Robles, Maneiro, Nueva Esparta',
                'phone'=>'04166964475',
                'email'=>'andrea@gmail.com',
                
            ],
            [
                'name'=>'Mary Jimenez',
                'direction'=>'Los Robles, Maneiro, Nueva Esparta',
                'phone'=>'04166956571',
                'email'=>'mary@gmail.com',
                
            ],
        ]);
    }
}
