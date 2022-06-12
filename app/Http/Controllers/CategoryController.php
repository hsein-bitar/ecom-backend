<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            "status" => 'success',
            "categories" => $categories,
        ], 200);
    }
    public function add(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->description = $request->description;
        $category->admin_id = auth()->user()->id;
        $category->save();

        return response()->json([
            "status" => 'success',
            "message" => "Category created successfully",
        ], 200);
    }
}
