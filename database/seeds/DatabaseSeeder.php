<?php

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
        $this->call(UsersTableSeeder::class);
        $this->call(SongsTableSeeder::class);
        $this->call(LyricsBoxesTableSeeder::class);
        $this->call(LyricsBoxLinesTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(EditHistoriesTableSeeder::class);
    }
}
