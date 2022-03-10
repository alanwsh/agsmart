<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image_folder = public_path('image');
        $files = File::files($image_folder);
        foreach($files as $file){
            $name = pathinfo($file)['filename'];
            $name = str_replace("_"," ",$name);
            Image::create([
                'name' => $name,
                'url' => asset('image/'.pathinfo($file)['basename']),
            ]);
        }
    }
}
