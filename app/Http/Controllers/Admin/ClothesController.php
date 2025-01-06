<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Clothes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClothesController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    /**
     * Display a listing of the resource for landing page.
     */
    public function landingPage()
    {
        $clothes = Clothes::latest()->paginate(10);
        $baseRoute = 'landing.detail';
        return view('home', compact('clothes', 'baseRoute'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clothes = Clothes::latest()->paginate(10);
        $baseRoute = 'admin.clothes.show';
        return view('admin.clothes.index', compact('clothes', 'baseRoute'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('admin.clothes.create', compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Form submitted', $request->all()); // Log all request data

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'size' => 'required|string',
                'limited_edition' => 'required|boolean',
                'color' => 'required|array',
                'categories' => 'required|array', // Expecting an array of category IDs
                'categories.*' => 'exists:categories,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Merge the selected colors into a string
        $colors = implode(', ', $validated['color']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/images/clothes/', $image->hashName());
        }

        $cloth = Clothes::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $image->hashName(),
            'size' => $validated['size'],
            'limited_edition' => $validated['limited_edition'],
            'color' => $colors,
        ]);

        // Attach categories to the cloth
        $cloth->categories()->sync($validated['categories']);

        return redirect()->route('admin.clothes.index')->with('success', 'Clothes added successfully.');
    }

    /**
     * Display the specified resource for landing page.
     */
    public function showLanding($id)
    {
        try {
            $cloth = Clothes::findOrFail($id);
            $clothes = Clothes::latest()->paginate(10);
            $baseRoute = 'landing.detail';

            // Get auth status from JWT
            $isAuthenticated = auth()->check();

            return view('landing.detail', compact('cloth', 'clothes', 'baseRoute', 'isAuthenticated'));
        } catch (\Exception $e) {
            return redirect()->route('products')->with('error', 'Product not found.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get product by ID
        $cloth = Clothes::findOrFail($id);

        // Get all products
        $clothes = Clothes::latest()->paginate(10);
        $baseRoute = 'admin.clothes.show';
        // Render view with Clothes
        return view('admin.clothes.detail', compact('cloth', 'clothes', 'baseRoute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //get product by ID
        $cloth = Clothes::findOrFail($id);
        $categories = Category::all(); // Fetch all categories

        //render view with Clothes
        return view('admin.clothes.edit', compact('cloth', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validate form
        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'stock' => 'integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size' => 'string',
            'limited_edition' => 'boolean',
            'color' => 'array',
            'categories' => 'array', // Expecting an array of category IDs
        ]);

        // Merge the selected colors into a string
        $colors = implode(', ', $validated['color']);

        //get clothes by ID
        $cloth = Clothes::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/images/clothes/', $image->hashName());

            //delete old image
            Storage::delete('public/images/clothes/' . $cloth->image);

            //update product with new image
            $cloth->update([
                'image'         => $image->hashName(),
                'name'         => $request->name,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock,
                'size'         => $request->size,
                'limited_edition' => $request->limited_edition,
                'color'         => $colors,
            ]);
        } else {

            //update product without image
            $cloth->update([
                'name'         => $request->name,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock,
                'size'         => $request->size,
                'limited_edition' => $request->limited_edition,
                'color'         => $colors,
            ]);
        }

        $cloth->categories()->sync($validated['categories']);

        return redirect()->route('admin.clothes.index')->with('success', 'Clothes added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the record by ID
        $cloth = Clothes::findOrFail($id);

        // Delete the record
        $cloth->delete();

        // Redirect with a success message
        return redirect()->route('admin.clothes.index')->with('success', 'Clothes deleted successfully.');
    }
}
