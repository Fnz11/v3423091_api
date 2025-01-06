<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clothes;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Clothes::with('categories');
            
            // Filter by category
            if ($request->category && $request->category !== 'all') {
                $query->whereHas('categories', function($q) use ($request) {
                    $q->where('categories.id', $request->category);
                });
            }

            // Filter by search query
            if ($request->has('search')) {
                $searchTerm = trim($request->search);
                if (!empty($searchTerm)) {
                    $query->where(function($q) use ($searchTerm) {
                        $q->where('name', 'like', "%{$searchTerm}%")
                          ->orWhere('description', 'like', "%{$searchTerm}%");
                    });
                }
            }

            // Apply sorting
            switch($request->filter) {
                case 'new_arrivals':
                    $query->latest('created_at');
                    break;
                case 'popular':
                    $query->orderBy('stock', 'asc');
                    break;
                case 'featured':
                    $query->where('limited_edition', true);
                    break;
                case 'all':
                default:
                    $query->orderBy('created_at', 'desc');
            }

            $clothes = $query->paginate(12);
            $categories = Category::orderBy('name')->get();
            
            return response()->json([
                'message' => 'Products retrieved successfully',
                'status' => 200,
                'data' => [
                    'products' => $clothes,
                    'categories' => $categories,
                    'total_products' => $clothes->total(),
                    'current_page' => $clothes->currentPage(),
                    'last_page' => $clothes->lastPage(),
                    'per_page' => $clothes->perPage()
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving products',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }

    public function categories()
    {
        try {
            $categories = Category::orderBy('name')->get();
            
            return response()->json([
                'message' => 'Categories retrieved successfully',
                'status' => 200,
                'data' => $categories
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving categories',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Clothes::with('categories')->find($id);
            
            if (!$product) {
                return response()->json([
                    'message' => 'Product not found',
                    'status' => 404,
                    'data' => null
                ], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'status' => 200,
                'data' => $product
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving product',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }

    public function serveImage($folder, $filename)
    {
        try {
            $path = storage_path("app/public/images/{$folder}/{$filename}");
            
            if (!file_exists($path)) {
                Log::error("Image not found", [
                    'path' => $path,
                    'folder' => $folder,
                    'filename' => $filename
                ]);
                return response()->json(['error' => 'Image not found'], 404);
            }

            $headers = [
                'Content-Type' => mime_content_type($path),
                'Cache-Control' => 'public, max-age=31536000',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET, OPTIONS',
                'Access-Control-Allow-Headers' => '*'
            ];

            return response()->file($path, $headers);
        } catch (\Exception $e) {
            Log::error("Error serving image", [
                'error' => $e->getMessage(),
                'path' => $path ?? null
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
