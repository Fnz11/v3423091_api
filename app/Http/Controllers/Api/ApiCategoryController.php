<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'Categories retrieved successfully',
            'status' => 200,
            'data' => $categories
        ], 200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
                'status' => 404,
                'data' => null
            ], 404);
        }
        return response()->json([
            'message' => 'Category retrieved successfully',
            'status' => 200,
            'data' => $category
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'status' => 201,
            'data' => $category
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'status' => 200,
            'data' => $category
        ], 200);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
            'status' => 200,
            'data' => null
        ], 200);
    }
}
