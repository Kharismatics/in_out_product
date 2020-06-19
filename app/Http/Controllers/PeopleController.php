<?php

namespace App\Http\Controllers;

use App\People;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Gate;

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
        $this->middleware('localization');
    }
    public function index()
    {
        $rows = People::where('created_by',Auth::user()->id)->get();
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
        session()->flash('message','Data successfully added');
        session()->flash('alert-class','alert-success');
        return redirect('/'.$this->page);
    }
    public function show(People $people)
    {
        if (Gate::allows('MainGate', $people)) {
            return response()->json($people);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'access denied'
            ]);
        }
    }
    public function edit(People $people)
    {
        if (Gate::allows('MainGate', $people)) {
            $row=$people;
            return view('pages.people.edit',compact('row'));
        } else {
            return redirect('/'.$this->page);
        }
    }
    public function update(Request $request, People $people)
    {
        $this->validate($request, $this->validate);
        if (Gate::allows('MainGate', $people)) {
            $data = People::find($people->id);
            if ($data) {
                $data->name = $request->name;
                $data->email = $request->email;
                $data->phone = $request->phone;
                $data->address = $request->address;
                $data = $data->save();
                session()->flash('message','Data successfully updated');
                session()->flash('alert-class','alert-success');
            } 
        }        
        return redirect('/'.$this->page);
    }
    public function destroy(People $people)
    {
        if (Gate::allows('MainGate', $people)) {
            $people->delete();
            session()->flash('message','Data successfully deleted');
            session()->flash('alert-class','alert-success');
        }
        return redirect('/'.$this->page);
    }
}
