<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Clothes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApiClothesController extends Controller
{
    public function index()
    {
        $clothes = Clothes::latest()->paginate(10);
        return response()->json([
            'message' => 'Clothes retrieved successfully',
            'status' => 200,
            'data' => $clothes
        ], 200);
    }

    public function show($id)
    {
        $cloth = Clothes::find($id);
        if (!$cloth) {
            return response()->json([
                'message' => 'Clothes not found',
                'status' => 404,
                'data' => null
            ], 404);
        }
        return response()->json([
            'message' => 'Clothes retrieved successfully',
            'status' => 200,
            'data' => $cloth
        ], 200);
    }

    public function store(Request $request)
    {
        Log::info('Form submitted', $request->all()); // Log all request data

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'image' => 'nullable|string', // Image is now optional
                'size' => 'required|string',
                'limited_edition' => 'required|boolean',
                'color' => 'required|array',
                'categories' => 'required|array', // Expecting an array of category IDs
                'categories.*' => 'exists:categories,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', $e->errors());
            return response()->json([
                'message' => 'Validation failed',
                'status' => 422,
                'data' => $e->errors()
            ], 422);
        }

        // Decode the base64 image if provided
        $imageName = null;
        if (!empty($validated['image'])) {
            $imageData = base64_decode($validated['image']);
            $imageName = uniqid() . '.png';
            Storage::put('public/images/clothes/' . $imageName, $imageData);
        } else {
            $imageName = 'default.png'; // Set a default image name if not provided
        }

        // Merge the selected colors into a string
        $colors = implode(', ', $validated['color']);

        $cloth = Clothes::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $imageName,
            'size' => $validated['size'],
            'limited_edition' => $validated['limited_edition'],
            'color' => $colors,
        ]);

        // Attach categories to the cloth
        $cloth->categories()->sync($validated['categories']);

        return response()->json([
            'message' => 'Clothes added successfully',
            'status' => 201,
            'data' => $cloth
        ], 201);
    }

    public function update(Request $request, $id)
    {
        Log::info('Form submitted', $request->all()); // Log all request data

        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric',
                'stock' => 'sometimes|integer',
                'image' => 'nullable|string', // Image is now optional
                'size' => 'sometimes|string',
                'limited_edition' => 'sometimes|boolean',
                'color' => 'sometimes|array',
                'categories' => 'sometimes|array', // Expecting an array of category IDs
                'categories.*' => 'exists:categories,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', $e->errors());
            return response()->json([
                'message' => 'Validation failed',
                'status' => 422,
                'data' => $e->errors()
            ], 422);
        }

        //get clothes by ID
        $cloth = Clothes::findOrFail($id);

        // Decode the base64 image if provided
        if (!empty($validated['image'])) {
            $imageData = base64_decode($validated['image']);
            $imageName = uniqid() . '.png';
            Storage::put('public/images/clothes/' . $imageName, $imageData);

            //delete old image
            Storage::delete('public/images/clothes/' . $cloth->image);

            $validated['image'] = $imageName;
        } else {
            // Keep the existing image if a new one is not provided
            $validated['image'] = $cloth->image;
        }

        // Merge the selected colors into a string if provided
        if (!empty($validated['color'])) {
            $validated['color'] = implode(', ', $validated['color']);
        }

        //update product
        $cloth->update($validated);

        if (!empty($validated['categories'])) {
            $cloth->categories()->sync($validated['categories']);
        }

        return response()->json([
            'message' => 'Clothes updated successfully',
            'status' => 200,
            'data' => $cloth
        ], 200);
    }

    public function destroy($id)
    {
        // Find the record by ID
        $cloth = Clothes::findOrFail($id);

        // Delete the record
        $cloth->delete();

        return response()->json([
            'message' => 'Clothes deleted successfully',
            'status' => 200,
            'data' => null
        ], 200);
    }
}
