<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
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
    public function sales()
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
            'transactions.unique_code',
            DB::raw('peoples.name as people'),
            DB::raw('if(transactions.transaction_type="in",products.name,products_out.name) as product'),
            DB::raw('if(transactions.transaction_type="in",transactions.base_price,0) as purchase'),
            DB::raw('if(transactions.transaction_type="in",0,transactions.price) as sales'),
            'transactions.transaction_type',
            )
        ->where('transactions.created_by', Auth::user()->id)
        ->where('transactions.transaction_status', 3)
        // ->where('transactions.transaction_date', DB::raw('curdate()'))
        // ->orderBy('transactions.transaction_type', 'desc')
        ->get();
        return view('pages.report.sales',compact('rows'));
        // foreach ($rows as $key => $value) {
        //     echo json_encode($value);
        //     echo '<br>';
        // }
    }
    public function stock()
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
        ->where('transactions.created_by', Auth::user()->id)
        ->where('transactions.transaction_status', 3)
        ->groupBy('product_id','product')
        // ->having('product', '<>', NULL)
        ->get();
        $rows = Arr::where(array_values($rows->toArray()), function ($value, $key) {
            return $value->product_id != null;
        });
        return view('pages.report.stock',compact('rows'));
    }
}