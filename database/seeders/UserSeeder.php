<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate all tables to start fresh
        DB::table('users')->truncate();
        DB::table('admin')->truncate();
        DB::table('mahasiswa')->truncate();
        DB::table('keasramaan')->truncate();
        DB::table('dosen')->truncate();
        DB::table('orang_tua')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed users and populate role-specific tables
        $this->seedUsersAndRoles();
    }

    /**
     * Seed users and populate role-specific tables.
     */
    private function seedUsersAndRoles()
    {
        // Define users with roles
        $users = [
            [
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'anak_wali' => null, // No anak wali for admin
            ],
            [
                'username' => 'mahasiswa',
                'password' => Hash::make('mahasiswa'),
                'role' => 'mahasiswa',
                'anak_wali' => 'dosen', // Mahasiswa is under dosen wali 1
            ],
            [
                'username' => 'dosen',
                'password' => Hash::make('dosen'),
                'role' => 'dosen',
                'anak_wali' => null, // Dosen as wali, no anak wali
            ],
            [
                'username' => 'keasramaan',
                'password' => Hash::make('keasramaan'),
                'role' => 'keasramaan',
                'anak_wali' => null, // No anak wali for keasramaan
            ],
            [
                'username' => 'orangtua',
                'password' => Hash::make('orangtua'),
                'role' => 'orang_tua',
                'anak_wali' => null, // No anak wali for orang tua
            ],
        ];

        // Insert users and populate role-specific tables
        foreach ($users as $user) {
            // Insert into the users table
            DB::table('users')->insert([
                'username' => $user['username'],
                'password' => $user['password'],
                'role' => $user['role'],
                'anak_wali' => $user['anak_wali'], // Add anak_wali column
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into the role-specific table
            switch ($user['role']) {
                case 'admin':
                    DB::table('admin')->insert([
                        'username' => $user['username'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                case 'mahasiswa':
                    DB::table('mahasiswa')->insert([
                        'username' => $user['username'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                case 'dosen':
                    DB::table('dosen')->insert([
                        'username' => $user['username'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                case 'keasramaan':
                    DB::table('keasramaan')->insert([
                        'username' => $user['username'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                case 'orang_tua':
                    DB::table('orang_tua')->insert([
                        'username' => $user['username'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;
            }
        }
    }
}