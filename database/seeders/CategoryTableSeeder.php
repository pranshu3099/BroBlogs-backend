<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $categories = [
            [
                'category_name' => 'Web Developemt',
                'slug' => '234',
            ],

            [
                'category_name' => 'Artificial Intelligence',
                'slug' => '19',
            ],
            [
                'category_name' => 'Machine Learning',
                'slug' => '1312',
            ],
            [
                'category_name' => 'Self Invention',
                'slug' => '199',
            ],
            [
                'category_name' => 'Programming Language',
                'slug' => '1612 ',
            ],

        ];

        foreach ($categories as $category) {
            $category['created_at'] = Carbon::now();
            $category['updated_at'] = Carbon::now();
            DB::table('categories')->insert($category);
        }
    }
}
