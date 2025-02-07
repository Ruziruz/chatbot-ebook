<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        Book::create([
            'title' => 'Hakikat Teks Berita',
            'content' => 'Hakikat Teks Berita... (isi lengkap teks yang ingin diberikan)',
        ]);
    }
}
