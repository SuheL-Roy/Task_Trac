<?php

namespace App\Http\Controllers;

use App\Models\TaskTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskTrackerController extends Controller
{
    public function store(Request $request)
    {

        $this->validate($request, [
            'task' => ['required']
        ]);
        $data = TaskTracker::create($request->all());
        $data->creator_id = Auth::user()->id;
        $data->save();
        return redirect()->back()->with('success', 'task Created successfully');
    }
    public function edit(Request $request)
    {
        $data = TaskTracker::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $data = TaskTracker::where('id', $request->id)->first();
        $data->update([
            'task' => $request->task,
        ]);
        return redirect()->back()->with('success', 'task updated successfully');
    }
    public function destroy(Request $request)
    {
        $data = TaskTracker::where('id', $request->id)->first();
        $data->delete();
        return redirect()->back()->with('danger', 'task deleted successfully');
    }
}
