<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    public function index(Request $request)
    {
        // check if favorites
        // check if category
        // check if search

    }
    public function show($id)
    {
        // return all details of this particular item

    }

    public function create(Request $request)
    {
        $request->validate([
            // 'email' => 'required|string|email',
            // 'password' => 'required|string',
        ]);

        $item = new Item();
        $item->title = $request->title;
        $item->details = $request->details;
        $item->price = $request->price;

        // TODO make sure image upload is working
        $item->image_uri = $request->image_uri;
        $item->admin_id = $request->admin_id;
        $item->save();
    }
}
