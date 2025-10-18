<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function rooms()
    {
        return view('admin.rooms.index');
    }

    public function roomsManagement()
    {
        return view('admin.rooms.management');
    }

    public function cafeteria()
    {
        return view('admin.cafeteria.index');
    }

    public function sessions()
    {
        return view('admin.sessions.index');
    }

    public function cafeteriaOverview()
    {
        return view('admin.cafeteria-overview.index');
    }

    public function sessionSummary(Session $session)
    {
        return view('admin.session-summary.index', compact('session'));
    }

    public function cancelSessionOnClose(Session $session)
    {
        // Reset the ended_at to null to resume billing when popup is closed
        $session->update([
            'ended_at' => null,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Session resumed']);
    }

    public function talabat(Session $session)
    {
        return view('admin.talabat.index', compact('session'));
    }

    public function reports()
    {
        return view('admin.reports.index');
    }
}
