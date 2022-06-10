<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Image;
use App\Models\Like;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    //
    public function index(Request $request)
    {
        // check if category
        if ($request->category) {
        }
        // TODO 
        // check if favorites
        // check if search
        $items = Item::with('likes')->get();


        return response()->json([
            'status' => 'success',
            'items' => $items,
        ]);
    }
    public function show($id)
    {
        // return all details of this particular item
        // $item = Item::findOrFail($id)
        // $item = Item::where('id', $id)
        $item = Item::where('items.id', '=', $id)
            ->with('likes')
            ->with('images')
            ->with('reviews')
            ->get();
        // get all images of this item from images table and add to response
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
        // $category = Category::findorFail($request->category);
        // dd($category);

        // if (!$category) {
        //     echo 'category missing';
        // }
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
}
