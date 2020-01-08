<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'id' => 'cgonzales',
            'user' => 'cgonzales',
            'password' => bcrypt('essalud19'),
            'tipo' => 1,
            'estado' => 1
        ]);

        // DB::table('user')->insert([
        //     'user' => 'notificador',
        //     'password' => bcrypt('notificador'),
        //     'tipo' => 2,
        //     'estado' => 1
        // ]);
    }
}
