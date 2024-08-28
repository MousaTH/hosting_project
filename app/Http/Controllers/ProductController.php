<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $formatted = $products->map(function ($product) {
            return [
                'product-title' => $product->name_of_product,
                'product-description' => $product->description_of_product,
                'category-name' => $product->category->category_name,
                'category-id' => $product->categories_id,
                'product-id' => $product->id,
                'user-id' => $product->user_id,
            ];
        });
        return response ()->json($formatted);

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
            'categories_id' =>'required|numeric',
        ]);
        $user = Auth::user();
        $validated['user_id'] = (string) $user->id;
        $product = Product::create([
            'name_of_product' => $validated['name_of_product'],
            'description_of_product' => $validated['description_of_product'],
            'user_id' => Auth::user()->id,
            'categories_id' => $validated['categories_id']
        ]);
        return response()->json($product);
    }
//23101976
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->find($id);
        return response()->json($product);
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
            'categories_id'=>'required|numeric'
        ]);
        $product->update($validated);
        return response()->json($product,201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    // Delete the product
    $product->delete();

    return response()->json(['message' => 'Product deleted successfully'], 200);
}
    /*
     * for api CRUD operation
     *
     * */
    public function upload(Request $request){
        $validateData = $request->validate([
            "name_of_product"=>'required|string|max:255',
            'description_of_product'=>'nullable|string',
            'image_of_product'=>'nullable|string',
            'categories_id' =>'required|numeric',
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
    /* * * * * * * * * * * * * * * * *
     * ASSOCIATE WITH USER FUNCTION **
     * * * **  ** * * * * * * * * * **
     * */
//    public function associateProduct(Request $request){
//        $user = AuthController::user();
//        $product = Product::findOrFail();
//    }
}
