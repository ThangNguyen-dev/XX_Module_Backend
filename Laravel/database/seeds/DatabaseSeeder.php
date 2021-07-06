<?php

use App\Organizer;
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
        $organizers = Organizer::all();
        foreach ($organizers as $organizer) {
            if ($organizer->slug == 'demo1') {
                $organizer->password_hash = bcrypt('demopass1');
            } else {
                $organizer->password_hash = bcrypt('demopass2');
            }
            $organizer->update();
        }
    }
}
