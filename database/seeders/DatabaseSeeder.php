<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void 
    { 
        User::create([ 
            'nama'     => 'Administrator', 
            'email'    => 'admin@gmail.com', 
            'username' => 'admin',
            'role'     => '1',
            'status'   => 1, 
            'hp'       => '0812345678901', 
            'password' => bcrypt('P@55word'), 
        ]); 

        User::create([ 
            'nama'     => 'Akbar Achmad Budiman', 
            'email'    => 'razorakbar123@gmail.com', 
            'username' => 'razorakbar123',
            'role'     => '0', 
            'status'   => 1, 
            'hp'       => '081234567892', 
            'password' => bcrypt('akbar1987'), 
        ]); 

        User::create([
            'nama'     => 'Fikri Alif',
            'email'    => 'fikrialif@gmail.com',
            'username' => 'fikrialif',
            'role'     => '0',
            'status'   => 1,
            'hp'       => '0895600781495',
            'password' => bcrypt('P@55word'),
        ]);
    
        User::create([
            'nama'     => 'Elinda Auliya Rahmawati',
            'email'    => 'elinda@gmail.com',
            'username' => 'elinda',
            'role'     => '0',
            'status'   => 1,
            'hp'       => '081776960532',
            'password' => bcrypt('P@55word'),
        ]);


       #data kategori
        Kategori::create([
            'nama_kategori' => 'Cookies',
        ]);
    }
}
