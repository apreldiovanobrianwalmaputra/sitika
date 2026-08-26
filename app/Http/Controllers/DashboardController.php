<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Ticket::query();

        // Pelapor hanya boleh melihat tiket miliknya sendiri
        if ($user->role === 'PELAPOR') {
            $query->where('reporter_id', $user->id);
        }

        $totalTickets = (clone $query)->count();

        $openTickets = (clone $query)
            ->where('status', 'OPEN')
            ->count();

        $inProgressTickets = (clone $query)
            ->where('status', 'IN_PROGRESS')
            ->count();

        $resolvedTickets = (clone $query)
            ->where('status', 'RESOLVED')
            ->count();

        $latestTickets = (clone $query)
            ->with(['category', 'reporter'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'latestTickets'
        ));
    }
}