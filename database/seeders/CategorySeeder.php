<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(5)->create();
        for( $i  = 0; $i < 5; $i++){
            $parent_id = Category::inRandomOrder()->pluck('id')->first();
            Category::factory(1)->create(['parent_id' => $parent_id]);
        }
    }
}
