<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Book::insert([
            [
                'title'       => 'Algebra Basics',
                'author'      => 'Ahmed Ali',
                'price'       => 120.00,
                'description' => 'An introduction to algebra for beginners.',
                'status'      => 'exist',
                'count'       => 5,
                'category_id' => 1, 
            ],
            [
                'title'       => 'World History',
                'author'      => 'Mohamed Hassan',
                'price'       => 95.50,
                'description' => 'A brief overview of world history.',
                'status'      => 'exist',
                'count'       => 5,
                'category_id' => 2, 
            ],
            [
                'title'       => 'Physics for Everyone',
                'author'      => 'Sara Ibrahim',
                'price'       => 150.00,
                'description' => 'Basic physics explained simply.',
                'status'      => 'exist',
                'count'       => 5,
                'category_id' => 3, 
            ],
        ]);
    }
}
