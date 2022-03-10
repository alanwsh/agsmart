<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use App\Rules\ValidImage;

class Image extends Model
{
    use HasFactory;

    const image_per_page = 9;

    protected $fillable = ['name','url'];
    
    public static function rules(){
        return [
            'name' => ['required'],
            'url' => ['required','url',new ValidImage]
        ];
    }

    public static function index(){
        return Image::all();
    }

    public static function Top10Viewed(){
        $image = self::orderBy('requestCount','desc')->limit(10)->get();
        $image->makeHidden(['created_at','updated_at']);
        return $image;
    }

    public static function getImageIndex($id){
        $images = self::all();
        $count = $images->where('id','<',$id)->count();
        return $count;
    }
    
    public static function getPageNumber($index){
        $count = self::all()->count();
        $page = (int)($index/self::image_per_page)+1;
        return $page;
    }

    public static function ImageByPagination($page){
        Paginator::currentPageResolver(fn() => $page);
        $images = self::paginate(self::image_per_page,['id','name','url','requestCount'])->toArray()['data'];
        foreach($images as &$image){
            $image['page'] = $page;
        }
        return $images;     
    }

    public static function mostPopularImage(){
        $image = self::orderBy('requestCount','desc')->limit(1)->get();
        $image->makeHidden(['created_at','updated_at']);
        return $image;
    }

}
