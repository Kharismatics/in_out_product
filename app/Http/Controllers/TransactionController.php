<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use App\People;
use App\Product;

use Auth;
use Illuminate\Support\Facades\Gate;

use Carbon\Carbon;

class TransactionController extends Controller
{
    protected   $page = 'transactions',
                $validate = [
                    'people_id'=> 'required',
                    'transaction_date'=> 'required|date',
                    'quantity'=> 'required',
                    'transaction_status'=> 'required',
                    'transaction_type'=> 'required',
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
        $rows = Transaction::with('product','people','transaction')->where('created_by',Auth::user()->id)->get();
        return view('pages.transaction.index',compact('rows'));
    }
    public function create()
    {
        $peoples = People::where('created_by',Auth::user()->id)->orderBy('name', 'DESC')->get();
        $products = Product::where('created_by',Auth::user()->id)->orderBy('name', 'DESC')->get();
        $transactions = Transaction::with('product','people')->where('created_by',Auth::user()->id)->where('transaction_type','in')->orderBy('transaction_date', 'DESC')->get();
        return view('pages.transaction.create',compact('peoples','products','transactions'));
    }
    public function store(Request $request)
    {
        $this->validate($request, $this->validate);
        $data = new Transaction;
        $data->product_id = $request->product_id;
        $data->people_id = $request->people_id;
        $data->transaction_id = $request->transaction_id;
        $data->transaction_date = Carbon::parse($request->transaction_date)->format('Y-m-d');
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
        session()->flash('message','Data successfully added');
        session()->flash('alert-class','alert-success');
        return redirect('/'.$this->page);
    }
    public function show(Transaction $transaction)
    {
        if (Gate::allows('MainGate', $transaction)) {
            return response()->json($transaction);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'access denied'
            ]);
        }
    }
    public function edit(Transaction $transaction)
    {
        if (Gate::allows('MainGate', $transaction)) {
            $row=$transaction;
            $peoples = People::where('created_by',Auth::user()->id)->orderBy('name', 'DESC')->get();
            $products = Product::where('created_by',Auth::user()->id)->orderBy('name', 'DESC')->get();
            $transactions = Transaction::where('created_by',Auth::user()->id)->where('transaction_type','in')->orderBy('id', 'DESC')->get();
            return view('pages.transaction.edit',compact('row','peoples','products','transactions'));
        } else {
            return redirect('/'.$this->page);
        }  
    }
    public function update(Request $request, Transaction $transaction)
    {
        $this->validate($request, $this->validate);
        if (Gate::allows('MainGate', $transaction)) {
            $data = Transaction::find($transaction->id);
            if ($data) {
                $data->product_id = $request->product_id;
                $data->people_id = $request->people_id;
                $data->transaction_id = $request->transaction_id;
                $data->transaction_date = Carbon::parse($request->transaction_date)->format('Y-m-d');
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
                session()->flash('message','Data successfully updated');
                session()->flash('alert-class','alert-success');
            } 
        }  
        return redirect('/'.$this->page);
    }
    public function destroy(Transaction $transaction)
    {
        if (Gate::allows('MainGate', $transaction)) {
            $transaction->delete();
            session()->flash('message','Data successfully deleted');
            session()->flash('alert-class','alert-success');
        }
        return redirect('/'.$this->page);
    }
}
