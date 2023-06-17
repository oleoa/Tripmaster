<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table("users")->insert([
          "id" => 1,
          "name" => env("ADMIN_NAME"),
          "email" => env("ADMIN_EMAIL"),
          "verification_token" => "verified",
          "password" => Hash::make(env("ADMIN_PASSWORD")),
        ]);

        DB::table("projects")->insert([
          "id" => 1,
          "country" => "France",
          "image" => "https://flagsapi.com/FR/flat/64.png",
          "start" => "2023-06-07",
          "end" => "2023-06-021",
          "headcount" => "1",
          "adults" => "1",
          "children" => "0",
          "owner" => "1",
        ]);

        DB::table("users")->where("id", "1")->update([
          "lastProjectOpened" => "1"
        ]);

        DB::table("stays")->insert([
          'id' => "1",
          'owner' => "1",
          'title' => "Estadia com vista a torre",
          'description' => "Apartamento completo com vista à torre",
          'capacity' => "2",
          'bedrooms' => "1",
          'price' => "250",
          'country' => "France",
          'city' => "Paris",
          "status" => "available"
        ]);
        
        DB::table("stays_images")->insert([
          'id' => "1",
          'stay' => "1",
          'image_path' => "2MzjgHDUGQyelrt0Ks8kVe5kp8dlB2A9xilXNV8v.jpg"
        ]);

        DB::table("stays_images")->insert([
          'id' => "2",
          'stay' => "1",
          'image_path' => "RGdelliFz6dY0rit36rLUPX2KE4krga6hz2sFlbX.jpg"
        ]);

        DB::table("stays_images")->insert([
          'id' => "3",
          'stay' => "1",
          'image_path' => "RoFS0burIm12uacdyZS0oDX3JcuhuOYkqSsttEkE.jpg"
        ]);
    }
}
