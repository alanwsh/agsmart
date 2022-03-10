<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use App\Rules\ValidImage;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;
use Storage;

class ApiController extends Controller
{
    public function images(){
        $images = Image::index();
        $images->makeHidden(['created_at','updated_at']);
        $page = 1;
        $index = 1;
        foreach($images as $image){
            if($index == Image::image_per_page+1){
                $page++;
                $index = 1;
            }
            $image->page = $page;
            $index++;
        }
        return $images;
    }

    public function image(Request $request){
        $image = Image::find($request->id);
        if($image){
            $index = Image::getImageIndex($request->id);
            $page = (int)Image::getPageNumber($index);
            $image->makeHidden(['created_at','updated_at']);
            $image->page = $page;
            return $image;
        }
        else
            return response('Image not found',404);
    }

    public function paginated_image(Request $request){
        $page = $request->page;
        $images = Image::ImageByPagination($page);
        return $images;
    }

    public function most_popular_image(){
        return Image::mostPopularImage();
    }

    public function create_image(Request $request){
        $data = json_decode($request->getContent(),true);
        $response = [];
        foreach($data['data'] as $image){      
            $validator = Validator::make($image,Image::rules());
            if($validator->fails()){
                return response()->json($validator->errors())->setStatusCode(Response::HTTP_BAD_REQUEST,Response::$statusTexts[Response::HTTP_BAD_REQUEST]);
            }else{
                $contents = file_get_contents($image['url']);
                $now = Carbon::now();
                $unique_code = $now->format('YmdHisu'); 
                $filename = $unique_code.'.'.pathinfo($image['url'],PATHINFO_EXTENSION);
                if(Storage::disk('public_uploads')->put($filename,$contents)){
                    if($saved_image = Image::create([
                        'name' => $image['name'],
                        'url' => $filename
                    ])){
                        $saved_image = $saved_image->makeHidden(['created_at','updated_at']);
                        $index = $saved_image->id;
                        $saved_image->page = Image::getPageNumber($index);
                        $response[] = $saved_image;
                    }
                }
            }
        }
        return response()->json($response)->setStatusCode(Response::HTTP_CREATED,Response::$statusTexts[Response::HTTP_CREATED]);
    }

    public function top10viewed(){
        return Image::Top10Viewed();
    }

}
