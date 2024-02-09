<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('dashboard.product.index', compact([
            'products'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.product.create', compact([
            'categories'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'price' => 'required',
            'amount' => 'required',
        ]);

        $code = mt_rand(1000000000, 9999999999);

        $product = new Product();
        $product->category_id = $request->category;
        $product->code = $code;
        $product->name = $request->name;
        $product->amount = $request->amount;
        $product->price = $request->price;
        $product->save();

        Alert::success('Congrats', 'Successfully added new Product');
        return redirect(route('product.index'));
    }

    /**
     * Display the specified resource.
     */
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        dd($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
