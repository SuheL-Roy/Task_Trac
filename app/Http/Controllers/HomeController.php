<?php

namespace App\Http\Controllers;

use App\Models\TaskTracker;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $d = new DateTime("now");
        $today = $d->format('Y-m-d');

        $formdate = $request->formdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }

        if ($formdate && $todate) {
            $creator_task = TaskTracker::where('creator_id', Auth::user()->id)->whereBetween(DB::raw('DATE(created_at)'), [$formdate, $todate])->get();
            return view('task', compact('creator_task', 'formdate', 'todate'));
        } else {
            $creator_task = TaskTracker::where('creator_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            return view('task', compact('creator_task', 'formdate', 'todate'));
        }
    }
}
