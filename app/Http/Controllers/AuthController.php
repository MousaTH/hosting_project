<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Category;
class AuthController extends Controller{

    public function register(Request $request){
        $Data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // 'name' => 'required|string',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number'=> 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20'
        ]);
        if(! filter_var($Data['email'], FILTER_VALIDATE_EMAIL)){
            return response()->json(['msg'=>'Invalid Email Address'],400);
        }
        if($Data['phone_number'] && !preg_match('/^([0-9\s\-\+\(\)]*)$/',$Data['phone_number'])){
            return response()->json(['msg'=>'Invalid Phone Number'],400);
        }
        $user = User::create([
            'first_name' => $Data['first_name'],
            'last_name' => $Data['last_name'],
            // 'name' => $Data['name'],
            'email' => $Data['email'],
            'password' => $Data['password'],
            'phone_number' => $Data['phone_number']
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user'=>$user,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The email or password are incorrect.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user'=>$user,
            'token_type' => 'Bearer',
            'auth type: ' => Auth::user(),
        ]);
    }
    public function show($id)
    {
        $user_id = (string) Auth::user()->id;
        if($user_id !== $id){

            return response()->json(['message'=>'Unauthorized','user id ' =>Auth::user()->id,'head id: ' =>$id ],401);
        }
        return response()->json(['user_name' => Auth::user()->first_name,
                                    'email' => Auth::user()->email,
                                    'phone_number'=> Auth::user()->phone_number,
                                    'user_product'=>Product::where('user_id', Auth::id())->get()->map(function($product){
                                        return [
                                            'id'=>$product->id,
                                            'name_of_product'=>$product->name_of_product,
                                            'description_of_product'=>$product->description_of_product,
                                            'category_data'=>Category::where('id', $product->categories_id)->get('category_name'),
                                            'image_of_product'=>$product->image_of_product
                                        ];
                                    }),]);
    
    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'],200);
    }
}
