<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Category;

use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    protected   $page = 'products',
                $validate = [
                    'name' => 'required',
                    // 'description' => 'required',
                ];
    
    public function __construct(Request $request)
    {
        if ($request->has('api_token')) {
            $this->middleware('auth:api');
        } else {
            $this->middleware('auth');
        }
        $this->middleware('localization');
    }
    public function index()
    {
        $rows = Product::with('category')->where('created_by',auth()->user()->id)->get();
        return view('pages.product.index',compact('rows'));
    }
    public function create()
    {
        $categories = Category::where('created_by',auth()->user()->id)->orderBy('name', 'DESC')->get();
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
        session()->flash('message', __('text.successfully_added'));
        session()->flash('alert-class','alert-success');
        return redirect('/'.$this->page);
    }
    public function show(Product $product)
    {
        if (Gate::allows('MainGate', $product)) {
            return response()->json($product);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'access denied'
            ]);
        }
    }
    public function edit(Product $product)
    {
        if (Gate::allows('MainGate', $product)) {
            $row=$product;
            $categories = Category::where('created_by',auth()->user()->id)->orderBy('name', 'DESC')->get();
            return view('pages.product.edit',compact('row','categories'));
        } else {
            return redirect('/'.$this->page);
        }        
    }
    public function update(Request $request, Product $product)
    {
        $this->validate($request, $this->validate);
        if (Gate::allows('MainGate', $product)) {
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
                session()->flash('message', __('text.successfully_updated'));
                session()->flash('alert-class','alert-success');
            } 
        }  
        return redirect('/'.$this->page);
    }
    public function destroy(Product $product)
    {
        if (Gate::allows('MainGate', $product)) {
            $product->delete();
            session()->flash('message', __('text.successfully_deleted'));
            session()->flash('alert-class','alert-success');
        }
        return redirect('/'.$this->page);
    }
}
