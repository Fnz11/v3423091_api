<?php

namespace App\Http\Controllers;

use App\Models\Clothes;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Clothes::with('categories');
        
        // Filter by category - modified to handle 'all' explicitly
        if ($request->category && $request->category !== 'all') {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Filter by search query - modified to handle empty search
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
                $query->orderBy('stock', 'asc'); // Assuming lower stock means more popular
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
        $totalProducts = $clothes->total();
        
        // Fix pagination with query strings
        $clothes->appends($request->query());
        
        if ($request->ajax()) {
            $gridView = view('components.clothes.cloth-grid', [
                'clothes' => $clothes,
                'baseRoute' => 'landing.detail'
            ])->render();

            $emptyStateView = view('components.empty-state')->render();

            return response()->json([
                'html' => $clothes->isEmpty() ? $emptyStateView : $gridView,
                'totalProducts' => $totalProducts,
                'pagination' => $clothes->isEmpty() ? '' : view('pagination::tailwind', ['paginator' => $clothes])->render()
            ]);
        }
        
        return view('products.index', compact('clothes', 'categories', 'totalProducts'));
    }
}
