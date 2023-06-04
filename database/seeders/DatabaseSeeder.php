<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TicketStatusSeeder::class);
        $this->call(TicketCategorySeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(TicketLogSeeder::class);
        $this->call(CommentSeeder::class);
    }
}
