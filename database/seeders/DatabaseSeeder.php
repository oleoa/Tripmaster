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
    DB::table("users")->insert([
      "id" => 1,
      "name" => env("ADMIN_NAME"),
      "email" => env("ADMIN_EMAIL"),
      "verification_token" => "verified",
      "password" => Hash::make(env("ADMIN_PASSWORD")),
    ]);

    DB::table("users")->insert([
      "id" => 2,
      "name" => "João",
      "email" => "joao@gmail.com",
      "verification_token" => "verified",
      "password" => Hash::make(env("ADMIN_PASSWORD")),
    ]);

    DB::table("users")->insert([
      "id" => 3,
      "name" => "Daniel",
      "email" => "daniel@gmail.com",
      "verification_token" => "verified",
      "password" => Hash::make(env("ADMIN_PASSWORD")),
    ]);

    DB::table("users")->insert([
      "id" => 4,
      "name" => "Afonso",
      "email" => "afonso@gmail.com",
      "verification_token" => "verified",
      "password" => Hash::make(env("ADMIN_PASSWORD")),
    ]);

    DB::table("users")->insert([
      "id" => 5,
      "name" => "Luis",
      "email" => "luis@gmail.com",
      "verification_token" => "verified",
      "password" => Hash::make(env("ADMIN_PASSWORD")),
    ]);

    DB::table("users")->insert([
      "id" => 6,
      "name" => "Marco",
      "email" => "marco@gmail.com",
      "verification_token" => "verified",
      "password" => Hash::make(env("ADMIN_PASSWORD")),
    ]);

    DB::table("stays")->insert([
      'id' => "1",
      'owner' => "2",
      'title' => "Cozy Cottage",
      'description' => "A charming cottage nestled in the countryside.",
      'image' => "p1.jpg",
      'capacity' => "2",
      'bedrooms' => "1",
      'address' => "123 Main Street",
      'price' => "100",
      'country' => "France",
      'city' => "Paris",
      'lat' => 48.8566,
      'lon' => 2.3522
    ]);

    DB::table("stays")->insert([
      'id' => "2",
      'owner' => "3",
      'title' => "Seaside Villa",
      'description' => "A luxurious villa with stunning ocean views.",
      'image' => "n1.jpg",
      'capacity' => "6",
      'bedrooms' => "3",
      'address' => "789 Beach Road",
      'price' => "250",
      'country' => "France",
      'city' => "Nice",
      'lat' => 43.7102,
      'lon' => 7.2620
    ]);

    DB::table("stays")->insert([
      'id' => "3",
      'owner' => "4",
      'title' => "Riverside Retreat",
      'description' => "A tranquil retreat by the river.",
      'image' => "b1.jpg",
      'capacity' => "4",
      'bedrooms' => "2",
      'address' => "456 Elm Avenue",
      'price' => "150",
      'country' => "Germany",
      'city' => "Berlin",
      'lat' => 52.5200,
      'lon' => 13.4050
    ]);

    DB::table("stays")->insert([
      'id' => "4",
      'owner' => "5",
      'title' => "Mountain Lodge",
      'description' => "A cozy lodge in the mountains.",
      'image' => "m1.jpg",
      'capacity' => "8",
      'bedrooms' => "4",
      'address' => "101 Pine Street",
      'price' => "200",
      'country' => "Germany",
      'city' => "Munich",
      'lat' => 48.1351,
      'lon' => 11.5820
    ]);

    DB::table("stays")->insert([
      'id' => "5",
      'owner' => "6",
      'title' => "City Apartment",
      'description' => "A modern apartment in the heart of the city.",
      'image' => "h1.jpg",
      'capacity' => "2",
      'bedrooms' => "1",
      'address' => "111 Main Street",
      'price' => "100",
      'country' => "Germany",
      'city' => "Hamburg",
      'lat' => 53.5511,
      'lon' => 9.9937
    ]);
    
    DB::table("stays_images")->insert([
      'id' => "1",
      'stay' => "1",
      'image_path' => "p1.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "2",
      'stay' => "1",
      'image_path' => "p2.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "3",
      'stay' => "1",
      'image_path' => "p3.jpg"
    ]);
    
    DB::table("stays_images")->insert([
      'id' => "4",
      'stay' => "2",
      'image_path' => "n1.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "5",
      'stay' => "2",
      'image_path' => "n2.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "6",
      'stay' => "2",
      'image_path' => "n3.jpg"
    ]);
    
    DB::table("stays_images")->insert([
      'id' => "7",
      'stay' => "3",
      'image_path' => "b1.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "8",
      'stay' => "3",
      'image_path' => "b2.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "9",
      'stay' => "3",
      'image_path' => "b3.jpg"
    ]);
    
    DB::table("stays_images")->insert([
      'id' => "10",
      'stay' => "4",
      'image_path' => "m1.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "11",
      'stay' => "4",
      'image_path' => "m2.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "12",
      'stay' => "4",
      'image_path' => "m3.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "13",
      'stay' => "5",
      'image_path' => "h1.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "14",
      'stay' => "5",
      'image_path' => "h2.jpg"
    ]);

    DB::table("stays_images")->insert([
      'id' => "15",
      'stay' => "5",
      'image_path' => "h3.jpg"
    ]);
  }
}
