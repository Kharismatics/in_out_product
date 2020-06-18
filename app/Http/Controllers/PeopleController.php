<?php

namespace App\Http\Controllers;

use App\People;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    protected   $page = 'peoples',
                $validate = [
                    'name' => 'required',
                    // 'email' => 'required',
                    // 'phone' => 'required',
                    'address' => 'required',
                ];
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $rows = People::all();
        return view('pages.people.index',compact('rows'));
    }
    public function create()
    {
        return view('pages.people.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, $this->validate);
        $data = new People;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->save();
        return redirect('/'.$this->page);
    }
    public function show(People $people)
    {
        //
    }
    public function edit(People $people)
    {
        $row=$people;
        return view('pages.people.edit',compact('row'));
    }
    public function update(Request $request, People $people)
    {
        $this->validate($request, $this->validate);
        $data = People::find($people->id);
        if ($data) {
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data = $data->save() ;
        } 
        return redirect('/'.$this->page);
    }
    public function destroy(People $people)
    {
        $people->delete();
        return redirect('/'.$this->page);
    }
}
