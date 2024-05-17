<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AlbumImages extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'image_name',
        'album_id',
    ];

    public function album(){
        return $this->belongsTo(Album::class);
    }

    public static function createAlbumImages(array $images,  $albumId){
        
        $imagesCounter = count($images);
        $albumImages=[];
        
        for ($i=0; $i < $imagesCounter ; $i++) { 
            
            $image_name = uploadImage( $images[$i] , 'albums/' ) ;
            $albumImages[]=[
                'image_name'=>$image_name,
                'album_id'=>$albumId
            ];
        }
        
       self::insert($albumImages);
       
    }

    public static function updateAlbumImages($images , $albumId){
        //
    }

    public static function removeImagesFromAlbum(array $imageIds, int $albumId){

        AlbumImages::whereIn('id', $imageIds)->where('album_id', $albumId)->delete();
        

    }
}
