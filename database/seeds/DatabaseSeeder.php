<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this -> call(CategoryTableSeeder::class);
        $this -> call(GenresTableSeeder::class);
        
    }
}
