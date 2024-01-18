<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $persons = User::all();
        return view('persons.index', compact('persons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('persons.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $person = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
        $filename = time() . '.' . request()->img->getClientOriginalExtension();
        request()->img->move(public_path('images'), $filename);

        $person->image = $filename;
        $person->save();
        return redirect('/persons')->with('success', 'Contact save successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $person = User::find($id);
        return view('persons.view', compact('person'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $person = User::find($id);
        return view('persons.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $person = User::find($id);
        $person->name = $request->get('name');
        $person->email = $request->get('email');
        $person->password = $request->get('password');
        $person->save();
        return redirect('/persons')->with('success', 'person update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $person = User::find($id);
        $person->delete();
        return redirect('/persons')->with('success', 'person deleted successfully');
    }
}
