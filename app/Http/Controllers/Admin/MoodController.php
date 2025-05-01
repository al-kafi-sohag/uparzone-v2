<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\MoodRequest;
use App\Models\Mood;

class MoodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function list()
    {
        $data['moods'] = Mood::orderBy('order', 'asc')->get();
        return view('admin.mood.list', $data);
    }

    public function create()
    {
        return view('admin.mood.create');
    }

    public function store(MoodRequest $request)
    {
        Mood::create($request->validated());
        sweetalert()->success('Mood created successfully');
        return redirect()->route('admin.mood.list');
    }

    public function edit($id)
    {
        $data['mood'] = Mood::findOrFail($id);
        return view('admin.mood.edit', $data);
    }

    public function update(MoodRequest $request, $id)
    {
        $mood = Mood::findOrFail($id);
        $mood->update($request->validated());
        sweetalert()->success('Mood updated successfully');
        return redirect()->route('admin.mood.list');
    }

    public function delete(Request $request)
    {
        $mood = Mood::findOrFail($request->id);
        $mood->delete();
        sweetalert()->success('Mood deleted successfully');
        return redirect()->route('admin.mood.list');
    }
}
