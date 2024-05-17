<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeAlbum;
use App\Models\Album;
use App\Models\AlbumImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class albumController extends Controller
{
    public function index(){
        
        $user_id = auth()->id();
        $allAlbums = Album::where('user_id', $user_id)->with('images')->get();

        return view('albums.index', compact('allAlbums'));
    }

    public function create(){
        
        return view('albums.create');
    }

    public function show(int $albumId){
        
        $album = Album::where('id', $albumId)->with('images')->firstOrFail();
        
        return view('albums.show', ['album'=>$album]);
    }

    public function edit(int $albumId){
        
        $album = Album::where('id', $albumId)->with('images')->firstOrFail();
        
        return view('albums.edit',  ['album'=>$album]);
    }

    public function update(storeAlbum $request){
        
        $inputs = $request->all();

        try {

            DB::beginTransaction();

                $album = Album::where('id',$inputs['album_id'])->firstOrFail();

                if ($album->name != $inputs['name']) {

                    $album->update([
                        'name'=> $inputs['name']
                    ]);
                }
     
                if (isset($inputs['deleted_images'])) {
                    AlbumImages::removeImagesFromAlbum($inputs['deleted_images'] , $album->id);
                }
                
                if (isset($inputs['new_images'])) {
                    AlbumImages::createAlbumImages($inputs['new_images'] , $album->id);
                }

            DB::commit();

        } catch (\Throwable $th) {
            
            DB::rollBack();
            throw $th;
        }

       return redirect()->route('home');
    }

    public function store(storeAlbum $request){
        
        $inputs = $request->all();

        try {

            DB::beginTransaction();

                $album = new Album();
                $album->name = $inputs['name'];
                $album->user_id = auth()->id();
                $album->save();
        
                AlbumImages::createAlbumImages($inputs['images'] , $album->id);

            DB::commit();

        } catch (\Throwable $th) {
            
            DB::rollBack();
            throw $th;
        }

       return redirect()->route('home');
    }

    public function delete(Request $request){
        
        $album_id = $request->album_id;

        $album = Album::whereId($album_id)->firstOrFail();

        if(isset($request->assign_images_to_another_album_id) ){
        
            AlbumImages::where('album_id',$album_id )
                        ->update(['album_id'=>$request->assign_images_to_another_album_id]);
        
        }else {
            
            AlbumImages::where('album_id',$album_id )->delete();
           
        }
        $album->delete();

        return redirect()->back();
    }

    public function getAlbums(Request $request){

        $albums = Album::whereNot('id' ,$request->expected_album_id)
        ->where('name', 'like', '%' . $request->term . '%')->orderBy('name')
        ->select('name as text', 'id')->get()->pluck('text','id')
        ->toArray();

        return json_encode($albums);
    }

}
