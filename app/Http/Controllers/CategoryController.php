<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function add(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->description = $request->description;
        $category->admin_id = $request->admin_id;
        $category->save();

        return response()->json([
            "message" => "Category created successfully",
        ], 200);
    }
}
