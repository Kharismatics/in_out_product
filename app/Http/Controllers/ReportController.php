<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Arr;

class ReportController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->has('api_token')) {
            $this->middleware('auth:api');
        } else {
            $this->middleware('auth');
        }
        $this->middleware('localization');
    }
    public function sales(Request $request)
    {
        $intervals = collect([
            ['interval' => 'DAY', 'caption' => __('text.today')],
            ['interval' => 'WEEK', 'caption' => __('text.this_week')],
            ['interval' => 'MONTH', 'caption' => __('text.this_month')],
            ['interval' => '', 'caption' => __('text.all')],
        ]);
        $interval = $request->input('interval');
        if ($request->method()=='GET') {
            $interval = 'DAY';
        }
        $rows = DB::table('transactions')
        ->join('peoples', 'peoples.id', '=', 'transactions.people_id')
        ->leftjoin('products', 'products.id', '=', 'transactions.product_id')
        ->leftjoin('transactions AS transactions_out', function ($join) {
            $join->on('transactions_out.id', '=', 'transactions.transaction_id')
                ->where('transactions_out.transaction_type', '=', 'in');
        })
        ->leftjoin('products AS products_out', 'products_out.id', '=', 'transactions_out.product_id')
        ->select(
            'transactions.transaction_date',
            'transactions.unique_code',
            DB::raw('peoples.name as people'),
            DB::raw('if(transactions.transaction_type="in",products.name,products_out.name) as product'),
            DB::raw('if(transactions.transaction_type="in",transactions.base_price,transactions.price) as price'),
            DB::raw('if(transactions.transaction_type="in",transactions.base_price*transactions.quantity,0) as purchase'),
            DB::raw('if(transactions.transaction_type="in",0,transactions.price*transactions.quantity) as sales'),
            DB::raw('if(transactions.transaction_type="in",0-(transactions.base_price*transactions.quantity),transactions.price*transactions.quantity) as total'),
            'transactions.quantity',
            )
        ->where('transactions.created_by', auth()->user()->id)
        ->where('transactions.transaction_status', 3)
        ->when($interval, function ($query, $interval) {
                    return $query->where(DB::raw("$interval(transactions.transaction_date)"), '=',  DB::raw("$interval(CURRENT_DATE())"));
                })
        ->orderBy('transactions.transaction_date', 'desc')
        ->get();
        return view('pages.report.sales',compact('rows','interval','intervals'));
    }
    public function debt(Request $request)
    {
        $rows = DB::table('transactions')
        ->join('peoples', 'peoples.id', '=', 'transactions.people_id')
        ->select(
            DB::raw('peoples.name as people'),
            DB::raw('if(transactions.transaction_type="in","'.__("text.debt").'","'.__("text.liability").'") as transaction_type'),
            DB::raw('sum(if(transactions.transaction_type="in",0-(transactions.base_price*transactions.quantity),transactions.price*transactions.quantity)) as total'),
            )
        ->where('transactions.created_by', auth()->user()->id)
        ->where('transactions.paid', 0)
        ->groupBy('people','transaction_type')
        ->get();
        return view('pages.report.debt',compact('rows'));
    }
    public function stocks()
    {
        $rows = DB::table('transactions')
        ->join('peoples', 'peoples.id', '=', 'transactions.people_id')
        ->leftjoin('products', 'products.id', '=', 'transactions.product_id')
        ->leftjoin('transactions AS transactions_out', function ($join) {
            $join->on('transactions_out.id', '=', 'transactions.transaction_id')
                ->where('transactions_out.transaction_type', '=', 'in');
        })
        ->leftjoin('products AS products_out', 'products_out.id', '=', 'transactions_out.product_id')
        ->select(
            DB::raw('if(transactions.transaction_type="in",products.id,products_out.id) as product_id'),
            DB::raw('if(transactions.transaction_type="in",concat("[",products.unique_code,"] ",products.name),concat("[",products_out.unique_code,"] ",products_out.name)) as product'),
            DB::raw('sum(if(transactions.transaction_type="in",transactions.quantity,0)-if(transactions.transaction_type="out",transactions.quantity,0)) as stock'),
            )
        ->where('transactions.created_by', auth()->user()->id)
        ->where('transactions.transaction_status', 3)
        ->groupBy('product_id','product')
        // ->having('product', '<>', NULL)
        ->get();
        $rows = Arr::where(array_values($rows->toArray()), function ($value, $key) {
            return $value->product_id != null;
        });
        return view('pages.report.stocks',compact('rows'));
    }
    public function stock($product)
    {
        $rows = DB::table('transactions')
        ->join('peoples', 'peoples.id', '=', 'transactions.people_id')
        ->leftjoin('products', 'products.id', '=', 'transactions.product_id')
        ->leftjoin('transactions AS transactions_out', function ($join) {
            $join->on('transactions_out.id', '=', 'transactions.transaction_id')
                ->where('transactions_out.transaction_type', '=', 'in');
        })
        ->leftjoin('products AS products_out', 'products_out.id', '=', 'transactions_out.product_id')
        ->select(
            'transactions.transaction_date',
            DB::raw('if(transactions.transaction_type="in",products.id,products_out.id) as product_id'),
            DB::raw('if(transactions.transaction_type="in",0+transactions.quantity,0-transactions.quantity) as stock'),
            )
        ->where('transactions.created_by', auth()->user()->id)
        ->where('transactions.transaction_status', 3)
        ->orderBy('transactions.transaction_date', 'asc')
        ->having('product_id', $product)
        ->get();
        $rows = Arr::where(array_values($rows->toArray()), function ($value, $key) {
            return $value->product_id != null;
        });
        return view('pages.report.stock',compact('rows'));
    }
}