<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected   $page = 'category',
                $validate = [
                    'name' => 'required',
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
    public function index(Request $request)
    {
        // $rows = Category::all(); /* all without Gate */
        // /* =Show data with Gate====== */
        // $rows = array();
        // foreach (Category::all() as $key => $value) {
        //     if (Gate::allows('MainGate', $value)) {
        //         \array_push($rows,$value);
        //     }
        // }
        // /* ========================== */
        $rows = Category::where('created_by',Auth::user()->id)->get();
        if ($request->has('api_token')) {
            return $rows;
        } else {
            return view('pages.category.index',compact('rows'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validate);
        $data = new Category;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();
        session()->flash('message', __('text.successfully_added'));
        session()->flash('alert-class','alert-success');
        return redirect('/'.$this->page);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (Gate::allows('MainGate', $category)) {
            return response()->json($category);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'access denied'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (Gate::allows('MainGate', $category)) {
            $row=$category;            
            return view('pages.category.edit',compact('row'));
        } else {
            return redirect('/'.$this->page);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, $this->validate);
        if (Gate::allows('MainGate', $category)) {
            $data = Category::find($category->id);
            if ($data) {
                $data->name = $request->name;
                $data->description = $request->description;
                $data = $data->save();
                session()->flash('message', __('text.successfully_updated'));
                session()->flash('alert-class','alert-success');
            } 
        }
        return redirect('/'.$this->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (Gate::allows('MainGate', $category)) {
            $category->delete();
            session()->flash('message', __('text.successfully_deleted'));
            session()->flash('alert-class','alert-success');
        }
        return redirect('/'.$this->page);
    }
}
