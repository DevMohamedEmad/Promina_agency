<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userAlbums = Album::where('user_id', auth()->id())
                            ->leftJoin('album_images as ai', 'ai.album_id' , 'albums.id')
                            ->select( DB::raw('if(ai.id is null , 0 ,1) as album_images_counter'), 'name', 'albums.id')
                            ->groupBy('albums.id')
                            ->get();

        return view('home', compact('userAlbums'));
    }
}
