<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{


    //return all inactive reviews for admin to activate or delete
    public function index()
    {
        // return all inactive reviews
        $reviews = Review::all()->where('status', '=', 0);
        return response()->json([
            "data" => $reviews,
        ], 200);
    }

    // called when a user adds a review
    public function create(Request $request)
    {
        $review = new Review();
        $review->text = $request->text;
        $review->rating = $request->rating;
        $review->user_id = $request->user_id;
        $review->restaurant_id = $request->restaurant_id;

        $review->save();
        return response()->json([
            "message" => "review added successfully, waiting admin approval",
        ], 200);
    }


    // activates or deletes a certain review
    public function activate(Request $request)
    {
        $action = $request->action;
        $review = Review::where('id', '=', $request->id)->first();

        if ($review) {
            if ($action == 0) {
                $review->delete();
                return response()->json([
                    "message" => "Review deleted successfully"
                ], 200);
            }

            $review->status = 1;
            $review->save();
            return response()->json([
                "message" => "Review activated successfully"
            ], 200);
        }
        return response()->json([
            "message" => "Review was not found"
        ], 200);
    }
}
