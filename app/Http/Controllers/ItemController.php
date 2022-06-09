<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    public function index(Request $request)
    {
        // TODO 
        // check if favorites
        // check if category
        // check if search
        $items = Item::all();

        return response()->json([
            'status' => 'success',
            'items' => $items,
            // 'authorisation' => [
            //     'token' => $token,
            //     'type' => 'bearer',
            // ]
        ]);
    }
    public function show($id)
    {
        // return all details of this particular item
        // TODO fix this method
        $item = Item::firstOrFail('id', $id);
        return response()->json([
            'status' => 'success',
            'item' => $item,
            // 'authorisation' => [
            //     'token' => $token,
            //     'type' => 'bearer',
            // ]
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            // 'email' => 'required|string|email',
            // 'password' => 'required|string',
        ]);

        $item = new Item();
        $item->title = $request->title;
        $item->category = $request->category;
        $item->details = $request->details;
        $item->price = $request->price;

        // TODO make sure image upload is working
        $item->image_uri = $request->image_uri;
        // TODO instead of getting admin id from frontend make it more secure get in on backend

        $item->admin_id = auth()->user()->id;
        $item->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully created item',
            'item' => $item,
            // 'authorisation' => [
            //     'token' => $token,
            //     'type' => 'bearer',
            // ]
        ]);
    }
}
