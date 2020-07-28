<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showChangeForm()
    {
        return view('auth.passwords.change');
    }

    public function change(Request $request)
    {
        $request->validate(['password' => 'required|confirmed|min:8'], $this->validationErrorMessages());

        $user = auth()->user();

        $user->password = bcrypt($request->password);

        session()->flash('message', __('text.successfully_updated_password'));
        session()->flash('alert-class','alert-success');
        
        return redirect('home');  
    }

    protected function validationErrorMessages()
    {
        return [];
    }

    public function sales_chart(Request $request)
    {
        $rows = DB::table('transactions')
        ->select(
            'transactions.transaction_date as name',
            DB::raw('sum(transactions.price*transactions.quantity) as aggregate'),
            )
        ->where('transactions.transaction_type', 'out')
        ->where('transactions.created_by', auth()->user()->id)
        ->where('transactions.transaction_status', 3)
        ->where('transactions.paid', 1)
        ->groupBy('transactions.transaction_date');

        if ($rows->count()) {
            return $this->Chart_js($rows->get());
        }
    }
    public function purchase_chart(Request $request)
    {
        $rows = DB::table('transactions')
        ->select(
            'transactions.transaction_date as name',
            DB::raw('sum(transactions.base_price*transactions.quantity) as aggregate'),
            )
        ->where('transactions.transaction_type', 'in')
        ->where('transactions.created_by', auth()->user()->id)
        ->where('transactions.transaction_status', 3)
        ->where('transactions.paid', 1)
        ->groupBy('transactions.transaction_date');
        
        if ($rows->count()) {
            return $this->Chart_js($rows->get());
        }
    }
    public function best_product_chart(Request $request)
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
            'products_out.name',
            DB::raw('count(products_out.id) aggregate'),
            )
        ->where('transactions.created_by', auth()->user()->id)
        ->where('transactions.transaction_status', 3)
        ->where('transactions.transaction_type', 'out')
        ->whereNotNull('products_out.id')
        ->groupBy('products_out.id')
        ->limit(10);;

        if ($rows->count()) {
            return $this->Chart_js($rows->get());
        }
    }
    public function best_customer_chart(Request $request)
    {
        $rows = DB::table('transactions')
        ->join('peoples', 'peoples.id', '=', 'transactions.people_id')
        ->select(
            'peoples.name',
            DB::raw('count(peoples.id) aggregate'),
            )
        ->where('transactions.created_by', auth()->user()->id)
        ->where('transactions.transaction_status', 3)
        ->where('transactions.transaction_type', 'out')
        ->whereNotNull('transactions.people_id')
        ->groupBy('transactions.people_id')
        ->limit(10);;

        if ($rows->count()) {
            return $this->Chart_js($rows->get());
        }
    }

    protected function Chart_js($data)
    {
        foreach ($data as $key => $value) {
            $label[] = $value->name;
            $aggregate[] = $value->aggregate;
        }
        return json_encode(array(
            'data'=>array(
                "labels"=>$label,
                "datasets"=>array(
                    array("data"=>$aggregate)
                    )
                ),
            ),JSON_NUMERIC_CHECK);   
    }  
}
