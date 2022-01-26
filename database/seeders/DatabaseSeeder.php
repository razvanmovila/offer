<?php

namespace Database\Seeders;

use App\Models\Listing;
use Database\Factories\ListingFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // Listing::factory(10)->create();

        $this->call(CitiesTableSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(ColorSeeder::class);
    }
}
