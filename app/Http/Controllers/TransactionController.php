<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use App\People;
use App\Product;

class TransactionController extends Controller
{
    protected   $page = 'transactions',
                $validate = [
                    'product_id'=> 'required',
                    'people_id'=> 'required',
                    'transaction_date'=> 'required',
                    'base_price'=> 'required',
                    'price'=> 'required',
                    'quantity'=> 'required',
                    'transaction_status'=> 'required',
                    'transaction_type'=> 'required',
                ];
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $rows = Transaction::with('product','people')->get();
        return view('pages.transaction.index',compact('rows'));
    }
    public function create()
    {
        $peoples = People::orderBy('name', 'DESC')->get();
        $products = Product::orderBy('name', 'DESC')->get();
        return view('pages.transaction.create',compact('peoples','products'));
    }
    public function store(Request $request)
    {
        $this->validate($request, $this->validate);
        $data = new Transaction;
        $data->product_id = $request->product_id;
        $data->people_id = $request->people_id;
        $data->transaction_date = $request->transaction_date;
        $data->base_price = $request->base_price;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->discount = $request->discount;
        $data->cost = $request->cost;
        $data->charge = $request->charge;
        $data->remark = $request->remark;
        $data->transaction_status = $request->transaction_status;
        $data->transaction_type = $request->transaction_type;
        $data->save();
        return redirect('/'.$this->page);
    }
    public function show(Transaction $transaction)
    {
        //
    }
    public function edit(Transaction $transaction)
    {
        $row=$transaction;
        $peoples = People::orderBy('name', 'DESC')->get();
        $products = Product::orderBy('name', 'DESC')->get();
        return view('pages.transaction.edit',compact('row','peoples','products'));
    }
    public function update(Request $request, Transaction $transaction)
    {
        $this->validate($request, $this->validate);
        $data = Transaction::find($transaction->id);
        if ($data) {
            $data->product_id = $request->product_id;
            $data->people_id = $request->people_id;
            $data->transaction_date = $request->transaction_date;
            $data->base_price = $request->base_price;
            $data->price = $request->price;
            $data->quantity = $request->quantity;
            $data->discount = $request->discount;
            $data->cost = $request->cost;
            $data->charge = $request->charge;
            $data->remark = $request->remark;
            $data->transaction_status = $request->transaction_status;
            $data->transaction_type = $request->transaction_type;
            $data = $data->save() ;
            // $data->update($request->all()); //need $fillabe on model
        } 
        return redirect('/'.$this->page);
    }
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect('/'.$this->page);
    }
}
