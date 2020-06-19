<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('localization');
    }
    public function daily()
    {
        $rows = DB::table('transactions')
                ->join('products', 'products.id', '=', 'transactions.product_id')
                ->join('peoples', 'peoples.id', '=', 'transactions.people_id')
                ->select(
                    DB::raw('peoples.name as people'),
                    DB::raw('products.name as product'),
                    'transactions.transaction_type',
                )
                ->where('transactions.created_by', Auth::user()->id)
                ->where('transactions.transaction_status', 3)
                ->where('transactions.transaction_date', DB::raw('curdate()'))
                ->orderBy('transactions.transaction_type', 'desc')
                ->get();
        return view('pages.report.daily',compact('rows'));
    }
    public function monthly()
    {
        $rows = DB::table('transactions')
                ->join('products', 'products.id', '=', 'transactions.product_id')
                ->join('peoples', 'peoples.id', '=', 'transactions.people_id')
                ->select(
                    DB::raw('peoples.name as people'),
                    DB::raw('products.name as product'),
                    'transactions.transaction_type',
                )
                ->where('transactions.created_by', Auth::user()->id)
                ->where('transactions.transaction_status', 3)
                ->where('transactions.transaction_date', DB::raw('curdate()'))
                ->orderBy('transactions.transaction_type', 'desc')
                ->get();
        return view('pages.report.daily',compact('rows'));
    }
}