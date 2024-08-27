<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request,$productId){
        $user= Auth::user();
        $product = Product::findOrFail($productId);
    if ( $user->favoriteProducts->where('product_id', $productId)->exists()) {
        $user->favoriteProducts->detach($productId);
        $is_favou = false;
        return response()->json(['message' => 'Product removed from favorite list'],200);
    }else{
        $user->favoriteProducts->attach($productId);
        $is_favou = true;
        return response()->json(['message' => 'Product added to favorite list'],200);
    }
    return response()->json(['is_favorite' => $isFavorite]);

        }

        public function index(Request $request){
            $user = Auth::user();
            $favorites = $user->favoriteProducts;
            return response()->json($favorites);
        }
    }

