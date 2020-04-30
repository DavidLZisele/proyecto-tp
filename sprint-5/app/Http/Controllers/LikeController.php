<?php

namespace App\Http\Controllers;

use App\Like;
use App\Posteo;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store()
    {
        $posteo = Posteo::find(request()->idposteo);
        Like::create([
            'id_user'=>request()->iduser,
            'id_posteo'=>request()->idposteo
        ]);
        $posteo->update([
            'cant_likes' => $posteo->cant_likes + 1
        ]);
        return redirect()->route('categoria.index');
    }
    public function destroy(Like $like)
    {
        $posteo = Posteo::find(request()->idposteo);
        $posteo->update([
            'cant_likes' => $posteo->cant_likes - 1
        ]);
        $like->delete();
        return redirect()->route('categoria.index');
    }
}
