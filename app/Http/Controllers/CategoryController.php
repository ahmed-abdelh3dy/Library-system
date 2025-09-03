<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\PseudoTypes\True_;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Cache::remember('categories_with_books', 60*60, function () {
        return Category::with('books')->get();
    });

    return response()->json($categories, 200);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = Category::create($data);

        return response()->json([
            'status' => True,
            'message' => 'Category created successfully',
            'category' => $category
        ] ,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('books');
        return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Category $category)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }


        $category->update($data);
        return response()->json([
            'status' => true,
            'message' => 'category updated',
            'category' => $category
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            "status"=> true,
            'message' => 'Category deleted successfully',
        ], 200);
    }


}
