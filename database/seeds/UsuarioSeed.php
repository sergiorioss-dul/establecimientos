<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Sergio',
            'email' => 'correo@correo.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12341234'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('users')->insert([
            'name' => 'Dul Rios',
            'email' => 'dul@correo.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12341234'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
