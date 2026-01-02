<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Bundle;
class MenuController extends Controller {
    public function index(){
        $products = Product::all();
        $bundles = Bundle::all();
        return view('menu.index', compact('products','bundles'));
    }
}
