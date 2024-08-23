<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories')->get();
        return response ()->json($products);

    }
    public function create(){
        $categories = Category::all();
        return view('home',compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_of_product' => 'required|string|max:255',
            'description_of_product' => 'nullable|string',
            //  'image_of_product' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categories_id' =>'required|numeric|exists:categories,id',
        ]);
//        if ($request->hasFile('image')) {
//            $imagePath = $request->file('image')->store('products', 'public');
//            $validated['image_of_product'] = $imagePath;
//        }else{
//            $validated['image_of_product'] = null;
//        }
        $product = Product::create($validated);
        return response()->json($product);
    }
//23101976
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
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name_of_product' => 'required|string|max:255',
            'description_of_product' => 'nullable|string',
            'image_of_product' => 'nullable|string',
        ]);
        $product->update($validated);
        return response()->json($product,201);
    }

    /**
     * Remove the specified resource from storage.
     */

    /*
     * for api CRUD operation
     *
     * */
    public function upload(Request $request){
        $validateData = $request->validate([
            "name_of_product"=>'required|string|max:255',
            'description_of_product'=>'nullable|string',
            'image_of_product'=>'nullable|string',
            'categories_id' =>'required|numeric|exists:categories,id',
        ]);
        $products = Product::create($validateData);
        return response()->json($products,201);
    }
    public function getData(Request $request){
        $products = Product::with('categories')->get();
        return response()->json($products,201);
    }
    public function showData(){
        $product = Product::with('categories')->get();
        return view('showProduct',compact('product'));
    }
}
