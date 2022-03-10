<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Image;

class ImageController extends Controller
{
    public function index(){
        return view('index');
    }
}
