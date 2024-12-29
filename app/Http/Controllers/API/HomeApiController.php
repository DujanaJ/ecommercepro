<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    /**
     * Display a welcome message for the API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Welcome to the API Home!',
        ]);
    }

    /**
     * Fetch a list of products (dummy data for now).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts()
    {
        $products = [
            ['id' => 1, 'name' => 'Product 1', 'price' => 100],
            ['id' => 2, 'name' => 'Product 2', 'price' => 200],
            ['id' => 3, 'name' => 'Product 3', 'price' => 300],
        ];

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Handle a sample POST request (e.g., submitting feedback).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitFeedback(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'feedback' => 'required|string|max:1000',
        ]);

        // Here, you could store feedback in the database.
        // For now, we return the submitted data.

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your feedback!',
            'data' => $request->only('name', 'feedback'),
        ]);
    }
}
