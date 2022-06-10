<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //
    public function toggle(Request $request)
    {
        $like = Like::where(
            'user_id',
            $request->user_id
        )->where(
            'item_id',
            $request->item_id
        )->get()->first();
        if ($like) {
            $like->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'like removed'
            ]);
        }
        $like = new Like();
        $like->user_id = $request->user_id;
        $like->item_id = $request->item_id;
        $like->save();
        return response()->json([
            'status' => 'success',
            'message' => 'like added'
        ]);
    }
}
