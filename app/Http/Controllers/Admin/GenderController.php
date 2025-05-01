<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\GenderRequest;
use App\Models\Gender;

class GenderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function list()
    {
        $data['genders'] = Gender::all();
        return view('admin.gender.list', $data);
    }

    public function create()
    {
        return view('admin.gender.create');
    }

    public function store(GenderRequest $request)
    {
        Gender::create($request->validated());
        sweetalert()->success('Gender created successfully');
        return redirect()->route('admin.gender.list');
    }

    public function edit($id)
    {
        $data['gender'] = Gender::findOrFail($id);
        return view('admin.gender.edit', $data);
    }

    public function update(GenderRequest $request, $id)
    {
        $gender = Gender::findOrFail($id);
        $gender->update($request->validated());
        sweetalert()->success('Gender updated successfully');
        return redirect()->route('admin.gender.list');
    }

    public function delete(Request $request)
    {
        $gender = Gender::findOrFail($request->id);
        $gender->delete();
        sweetalert()->success('Gender deleted successfully');
        return redirect()->route('admin.gender.list');
    }
}
