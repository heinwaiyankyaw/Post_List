<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::redirect('/', 'customer/createPage', 301)->name('post#home');
// Route::get('/', [PostController::class, 'create'])->name('post#home');
Route::get('customer/createPage',[PostController::class,'create'])->name('post#createPage');
Route::post('postCreate',[PostController::class,'postCreate'])->name('post#create');

Route::get('post/delete/{id}',[PostController::class,'postDelete'])->name('post#delete');

Route::get('post/updatePage/{id}',[PostController::class,'postUpdate'])->name('post#update');
Route::get('post/editPage/{id}',[PostController::class,'postEdit'])->name('post#edit');
Route::post('post/update',[PostController::class,'update'])->name('post#editData');

//db relation test
Route::get('product/list',function(){
    $data = Product::select('products.*','categories.name as category_name')
            ->join('categories','products.category_id','categories.id')
            ->get();
    dd($data->toArray());
});

Route::get('order/list',function(){
    $data = Order::select('orders.customer_id','orders.product_id','customers.name as customer_name','products.name as product_name', 'products.price','categories.name as categories_name')
            ->join('customers','orders.customer_id','customers.id')
            ->join('products','orders.product_id','products.id')
            ->join('categories','products.category_id','categories.id')
            ->get();
    dd($data->toArray());
});
