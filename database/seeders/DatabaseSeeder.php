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
          "name" => "Leonardo",
          "email" => "admin@tripmaster",
          "password" => Hash::make("admin123"),
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
          "owner" => "1"
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
          'price' => "20000",
          'country' => "France",
          'city' => "Paris",
          'beingUsed' => "false"
        ]);

        DB::table("stays_images")->insert([
          'id' => "1",
          'stay' => "1",
          'image_path' => "TteZDZ9OnxhGliSsmQrfFxR2zwSjRB8XfwbCsx4y.jpg"
        ]);

        DB::table("stays_images")->insert([
          'id' => "1",
          'stay' => "1",
          'image_path' => "Dx1sR29Q6KJWT2XfIWkon5VOmIdYXzwR5COD3MTy.jpg"
        ]);

        DB::table("stays_images")->insert([
          'id' => "1",
          'stay' => "1",
          'image_path' => "xqKFcuGTGSpoHfsjpBQgH4n9O2mkrJ4K2XotcUrl.jpg"
        ]);
    }
}
