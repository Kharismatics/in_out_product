<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    // mengambil semua data
    public function all()
    {
        return Person::all();
    }

    // mengambil data by id
    public function show($id)
    {
        return Person::find($id);
    }

    // menambah data
    public function store(Request $request)
    {
        return Person::create($request->all());
    }

    // mengubah data
    public function update($id, Request $request)
    {
        $person = Person::find($id);
        $person->update($request->all());
        return $person;
    }

    // menghapus data
    public function delete($id)
    {
        $person = Person::find($id);
        $person->delete();
        return 204;
    }
}
