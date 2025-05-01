<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ReligionRequest;
use App\Models\Religion;

class ReligionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function list()
    {
        $data['religions'] = Religion::latest()->get();
        return view('admin.religion.list', $data);
    }

    public function create()
    {
        return view('admin.religion.create');
    }

    public function store(ReligionRequest $request)
    {
        Religion::create($request->validated());
        sweetalert()->success('Religion created successfully');
        return redirect()->route('admin.religion.list');
    }

    public function edit($id)
    {
        $data['religion'] = Religion::findOrFail($id);
        return view('admin.religion.edit', $data);
    }

    public function update(ReligionRequest $request, $id)
    {
        $religion = Religion::findOrFail($id);
        $religion->update($request->validated());
        sweetalert()->success('Religion updated successfully');
        return redirect()->route('admin.religion.list');
    }

    public function delete(Request $request)
    {
        $religion = Religion::findOrFail($request->id);
        $religion->delete();
        sweetalert()->success('Religion deleted successfully');
        return redirect()->route('admin.religion.list');
    }
}
