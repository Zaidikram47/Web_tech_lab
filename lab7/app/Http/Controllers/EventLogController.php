<?php

namespace App\Http\Controllers;

use App\Models\EventLog;
use Illuminate\Http\Request;

class EventLogController extends Controller
{
    public function index()
    {
        $logs = EventLog::latest()->paginate(20);
        return view('event-logs.index', compact('logs'));
    }

    public function destroy(Request $request)
    {
        EventLog::truncate();
        return redirect()->route('event-logs.index')->with('success', 'All event logs cleared.');
    }
}
