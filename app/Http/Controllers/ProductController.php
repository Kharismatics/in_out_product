<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Category;

class ProductController extends Controller
{
    protected   $page = 'products',
                $validate = [
                    'name' => 'required',
                    'description' => 'required',
                ];
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $rows = Product::with('category')->get();
        return view('pages.product.index',compact('rows'));
    }
    public function create()
    {
        $categories = Category::orderBy('name', 'DESC')->get();
        return view('pages.product.create',compact('categories'));
    }
    public function store(Request $request)
    {
        $this->validate($request, $this->validate);
        $data = new Product;
        $data->unique_code = $request->unique_code;
        $data->category_id = $request->category_id;
        $data->name = $request->name;
        $data->base_price = $request->base_price;
        $data->price = $request->price;
        $data->description = $request->description;
        $data->save();
        return redirect('/'.$this->page);
    }
    public function show(Product $product)
    {
        //
    }
    public function edit(Product $product)
    {
        $row=$product;
        $categories = Category::orderBy('name', 'DESC')->get();
        return view('pages.product.edit',compact('row','categories'));
    }
    public function update(Request $request, Product $product)
    {
        $this->validate($request, $this->validate);
        $data = Product::find($product->id);
        if ($data) {
            $data->unique_code = $request->unique_code;
            $data->category_id = $request->category_id;
            $data->name = $request->name;
            $data->base_price = $request->base_price;
            $data->price = $request->price;
            $data->description = $request->description;
            $data = $data->save() ;
            // $data->update($request->all()); //need $fillabe on model
        } 
        return redirect('/'.$this->page);
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/'.$this->page);
    }
}
