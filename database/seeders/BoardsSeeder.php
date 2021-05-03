<?php

namespace Database\Seeders;
use App\Models\Boards;
use Illuminate\Database\Seeder;

class BoardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Boards::factory()
                ->count(10)
                ->create();
    }
}
