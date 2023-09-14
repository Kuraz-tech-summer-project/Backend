<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        $fields = $request->validate([
            'userId' => 'required',
            'productId' => 'required',
            'review' => 'required|string',
            'rating' => 'required'
        ]);

        $user_exists = User::where('id', $fields['userId'])->exists();
        //Todo: Check if product also exists
        if ($user_exists) {
            $review = Review::create([
                'user_id' => $fields['userId'],
                'product_id' => $fields['productId'],
                'review' => $fields['review'],
                'rating' => $fields['rating']
            ]);
            
            return new ReviewResource($review);
        }

        return response([
            'message' => 'User does not exist'
        ], 403);
    }

    public function findById(Request $request, string $id)
    {
        $review = Review::find($id);

        if (is_null($review) || empty($review)) {
            return response([
                'message' => 'review was not found!'
            ], 404);
        }

        return new ReviewResource($review);
    }

    public function findByUserId(Request $request, string $userId)
    {
        if (!$userId) {
            return response([
                'message' => 'user id was not provided!'
            ], 403);
        }

        $review = Review::where('user_id', $userId)->get();
        if (is_null($review) || empty($review)) {
            return response([
                'message' => 'review was not found!'
            ], 404);
        }

        return new ReviewCollection($review);
    }

    public function findByProductId(Request $request, string $productId)
    {
        if (!$productId) {
            return response([
                'message' => 'product id was not provided!'
            ], 403);
        }

        $review = Review::where('product_id', $productId)->get();
        if (is_null($review) || empty($review)) {
            return response([
                'message' => 'review was not found!'
            ], 404);
        }

        return new ReviewCollection($review);
    }

    public function editReview(Request $request, string $reviewId)
    {
        if (!$reviewId) {
            return response([
                'message' => 'review id was not provided!'
            ], 403);
        }

        $review = Review::find($reviewId);
        $review->update($request->all());
        return new ReviewResource($review);
    }

    public function deleteReview(Request $request, string $reviewId)
    {
        if (!$reviewId) {
            return response([
                'message' => 'review id was not provided!'
            ], 403);
        }

        $review = Review::find($reviewId);
        $review->delete();
        $response = [
            'message' => 'review was successfully deleted!'
        ];

        return response($response, 200);
    }

    public function getReviews(Request $request)
    {
        return new ReviewCollection(Review::paginate());
    }
}
