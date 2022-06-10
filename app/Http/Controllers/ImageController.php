<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    //
    public function add(Request $request)
    {
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $name = time() . Str::random(5) . '.' . $image->getClientOriginalExtension();
                    Storage::disk('images')->put($name, file_get_contents($image));
                    $image_uri = asset('storage/items_images/' . $name);
                    $images[] =  $image_uri;
                    // TODO put the url into table images
                    $item_image = new Image();
                    $item_image->image_uri = $image_uri;
                    $item_image->name = $request->name;
                    $item_image->item_id = $request->item_id;
                    $item_image->admin_id = $request->admin_id;
                    $item_image->save();
                }
            }
        }
        return response()->json([
            'status' => 'success',
            // return public access url
            'images' => count($images) > 0 ? $images : 'nofiles',
        ]);
    }
}
