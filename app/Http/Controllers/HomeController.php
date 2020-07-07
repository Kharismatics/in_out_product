<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
