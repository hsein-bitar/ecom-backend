<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Image;
use App\Models\Like;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();
        // TODO fix fav API
        // if ($request->favorites == true) {
        //     $query = Item::join('likes', function ($join) {
        //         $join->on('likes.item_id', '=', 'items.id')
        //             ->where('likes.user_id', '=', 2);
        //     });
        // }
        $query = Item::where('title', 'like', '%' . $request->search . '%');
        if ($request->category_id) {
            $query = $query->where('category_id', $request->category_id);
        }
        $items = $query
            ->with('likes')
            ->withCount('likes')->get();
        return response()->json([
            'status' => 'success',
            'items' => $items,
        ]);
    }
    public function show($id)
    {
        // return all details of this particular item
        $item = Item::where('items.id', '=', $id)
            ->with('likes')
            ->withCount('likes')
            ->with('images')
            ->with('reviews')
            // TODO avg rating, , AVG('reviews.rating')
            ->get();

        // $images = Image::all()->where('item_id', $item->id);
        // $likes = Like::where('item_id', $item->id)->get();
        if ($item) {
            return response()->json([
                'status' => 'success',
                'item' => $item,
                // 'images' => $images,
                // 'likes' => $likes,
            ]);
        } //TODO handle not found response
    }

    public function create(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->image;
            if ($image->isValid()) {
                $name = time() . Str::random(5) . '.' . $image->getClientOriginalExtension();
                Storage::disk('images')->put($name, file_get_contents($image));
                $image_uri = asset('storage/items_images/' . $name);

                $item = new Item();
                $item->title = $request->title;
                $item->category_id = $request->category_id;
                $item->details = $request->details;
                $item->price = $request->price;
                $item->image_uri = $image_uri;

                // instead of getting admin id from frontend make it more secure get in on backend
                $item->admin_id = auth()->user()->id;
                $item->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully created item',
                    'item' => $item,
                ]);
            }
        }
    }

    // public function favorites(Request $request)
    // {
    //     // $user = auth()->user();
    //     $user = Auth::user();
    //     // $favorites = $user->items()->pivot->where("user_id",  auth()->user()->id);
    //     $favorites = Auth::user()->items()->where("user_id",  auth()->user()->id)->get();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Here are your favorites',
    //         'items' => $favorites,
    //     ]);
    // }
}
