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
        // if ($request->has('api_token')) {
        //     $this->middleware('auth:api');
        // } else {
        //     $this->middleware('auth');
        // }
        // $this->middleware('localization');
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
        ->groupBy('transactions.transaction_date')
        ->get();

        return $this->Chart_js($rows);
    }
    public function purchase_chart(Request $request)
    {
        $rows = DB::table('transactions')
        ->select(
            'transactions.transaction_date as name',
            DB::raw('sum(transactions.base_price*transactions.quantity) as aggregate'),
            )
        ->where('transactions.transaction_type', 'in')
        ->groupBy('transactions.transaction_date')
        ->get();

        return $this->Chart_js($rows);
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
