<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('myproduct')->get();
        $formated_data = $categories->map(function ($categ) {
            return [
                'id' =>$categ->id,
                'category_name' =>  $categ->category_name,
                //'category_name' => $product->category->category_name,
                'product_belong_to'=>Product::where('categories_id', $categ->id)->get('name_of_product'),
            ];
           });
        return response()->json($formated_data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name'=>'required|string',
            'category_icon'=>'required|string',
        ]);
        $categ = Category::create($validated);
        return response()->json($categ);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $categ = Category::findOrFail($id);
        $validated = $request->validate([
            'category_name'=>'required|string',
            'category_icon'=>'required|string',
        ]);
        $categ->update($validated);
        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $categ
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
