<?php

use App\Http\Controllers\ProfileController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return redirect()->route('login');
})->middleware(App\Http\Middleware\CheckPermission::class)->name('root_of_project');

Route::get('/dashboard', function (Request $request) {
    $user = $request->user();
    
    if($user->is_admin){
        $products=Product::all();
        return view('dashboard',compact('user','products'));
    }
    else{
        $products = Product::where('added_by', $user->id)->get();
        return view('dashboard',compact('user','products'));
    }
})->middleware(['auth', 'verified',App\Http\Middleware\CheckPermission::class])->name('dashboard');



Route::delete('/delete_product', function (Request $request) {
    //echo $request->delete_id;exit;
    
    $user = $request->user();
    if($user->is_admin){


        $product = Product::find($request->delete_id);
        $product->delete();


        return redirect()->back()->with('success_delete', 'Product Deleted successfully!');
    }
    else{
        return redirect()->back()->with('Error_delete', 'Error');
    }
    

})->middleware(['auth', 'verified',App\Http\Middleware\CheckPermission::class])->name('delete_product');

Route::put('/edit_product', function (Request $request) {
    
    $user = $request->user();
    if($user->is_admin){


        $product = Product::find($request->edit_id);
        return view('edit_product',compact('user','product'));
    }
    else{
        return redirect()->back()->with('Error_edit', 'Error');
    }
    

})->middleware(['auth', 'verified',App\Http\Middleware\CheckPermission::class])->name('edit_product');

Route::put('/update_product', function (Request $request) {

    //echo $request->update_id;exit;
    
    $user = $request->user();
    if($user->is_admin){


        Product::where('id', $request->update_id)->update([
            'name' => $request->name,
            'price' => $request->price
        ]);
        
        return redirect()->route('dashboard');
    }
    else{
        return redirect()->route('dashboard');
    }
    

})->middleware(['auth', 'verified',App\Http\Middleware\CheckPermission::class])->name('update_product');





Route::post('/add_product', function (Request $request) {
    $user = $request->user();
    if($user->is_admin){

        Product::create([
            'name'=> $request->name,
            'price'=>$request->price,
            'added_by'=>$user->id
        ]);


        return redirect()->back()->with('success', 'Product added successfully!');
    }
    else{
        return redirect()->back()->with('Error', 'Error');
    }
    
    
})->middleware(['auth', 'verified',App\Http\Middleware\CheckPermission::class])->name('add_product');

Route::middleware(['auth',App\Http\Middleware\CheckPermission::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
