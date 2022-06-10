<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //
    public function toggle(Request $request)
    {

        $like = Like::all();
        $like = Like::all()->where([
            'user_id' => $request->user_id,
            'item_id' => $request->item_id,
        ]);
        dd($like);
        // $like = new Like();
        // $like->user_id = $request->user_id;
        // $like->item_id = $request->item_id;
        // $like->save();
    }
}
