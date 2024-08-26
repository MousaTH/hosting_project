<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return response ()->json($products);

    }
    public function create(){
        $categories = Category::all();
        return view('home',compact('category'));
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
            'categories_id' =>'required|numeric',
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
