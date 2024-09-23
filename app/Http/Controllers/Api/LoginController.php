<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
class LoginController extends Controller
{
    //

    public function view(Request $request){

          $user_find = Auth::user();
          $user = User::where('id', $user_find->id)->first();


          //$products = Product::where('added_by', $user->id)->get();
          $products=$user->products()->get();

          $data=[];

          foreach($products as $product){
            $product_send=[
                'id'=>$product->id,
                'name'=>$product->name,
                'price'=>$product->price,
                'added_by'=>$user->email,
                'created_at'=>$product->created_at,
               ];
               array_push($data,$product_send);
          }

          return response()->json([
            'product_list'=>$data,
            'message'=>'product created'
        ]);
    }

    public function create(Request $request){
        
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:'.Product::class],
            'price' => ['required','numeric','min:0.01'],
        ]);
        
        $user = Auth::user();

        $product=Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'added_by'=>$user->id,

        ]);

        $product_send=[
            'id'=>$product->id,
            'name'=>$product->name,
            'price'=>$product->price,
            'added_by'=>$user->email,
            'created_at'=>$product->created_at,
           ];

           return response()->json([
            'product'=>$product_send,
            'message'=>'product created'
        ]);

        
        

    }

    public function login(Request $request)  {

        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'confirmed'],
        ]);

       // $check_user_exist=User::where('email',$request->email)->get();

        $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        // Invalid email or password
        
        $data_error=[
            'error'=>'user not found'
        ];
        return json_encode($data_error);
    }
    $user->tokens()->delete();
           $token = $user->createToken('Api token of '.$user->name)->plainTextToken; 

           $user_send=[
            'name'=>$user->name,
            'email'=>$user->email,
            'created_at'=>$user->created_at,
           ];

            return response()->json([
                'user'=> $user_send,
                'token' => $token
            ]);

/*
    $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            $token = $user->createToken('Api token of '.$user->name)->plainTextToken; 

            return response()->json([
                'user'=> $user,
                'token' => $token
            ]);
        }

*/
//$user->tokens()->delete();

    }

    public function register(Request $request){

        //$check_user_exist=User::where('email',$request->email)->get();

       // return json_encode($check_user_exist);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        

    $user=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),

    ]);
    $user_send=[
        'name'=>$user->name,
        'email'=>$user->email,
        'created_at'=>$user->created_at,
       ];
    return json_encode([
        'user'=>$user_send,
        'token'=> $user->createToken('Api token of '.$user->name)->plainTextToken,
    ]);

        //return response()->json('register');
    }
    public function logout(Request $request){

        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'confirmed'],
        ]);

       // $check_user_exist=User::where('email',$request->email)->get();

        $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        // Invalid email or password
        
        $data_error=[
            'error'=>'user not found'
        ];
        return json_encode($data_error);
    }
    $user->tokens()->delete();

       // return response()->json('logout');

       $user_send=[
        'name'=>$user->name,
        'email'=>$user->email,
        'created_at'=>$user->created_at,
       ];

        return response()->json([
            'user'=> $user_send,
            'token' => 'Logout out successful. Access token deleted'
        ]);
    }


}
