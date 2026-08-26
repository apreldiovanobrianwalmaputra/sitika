<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Ticket::query();

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

        // Nilai tambah Analisis Data
        $categoryStats = collect();
        $urgencyStats = collect();
        $resolutionRate = 0;
        $uniqueLocations = 0;
        $avgResolutionMinutes = null;

        if ($user->role === 'TEKNISI') {

            $categoryStats = Ticket::selectRaw(
                'category_id, COUNT(*) as total'
            )
                ->with('category:id,name')
                ->groupBy('category_id')
                ->orderByDesc('total')
                ->get();

            $urgencyStats = Ticket::selectRaw(
                'urgency, COUNT(*) as total'
            )
                ->groupBy('urgency')
                ->orderByDesc('total')
                ->get();

            $resolutionRate = $totalTickets > 0
                ? round(($resolvedTickets / $totalTickets) * 100, 1)
                : 0;

            $uniqueLocations = Ticket::query()
                ->distinct()
                ->count('location');

            $avgResolutionMinutes = DB::table('ticket_logs')
                ->join(
                    'tickets',
                    'ticket_logs.ticket_id',
                    '=',
                    'tickets.id'
                )
                ->where('ticket_logs.new_status', 'RESOLVED')
                ->selectRaw(
                    'AVG(
                        TIMESTAMPDIFF(
                            MINUTE,
                            tickets.created_at,
                            ticket_logs.created_at
                        )
                    ) as avg_minutes'
                )
                ->value('avg_minutes');

            if ($avgResolutionMinutes !== null) {
                $avgResolutionMinutes =
                    round($avgResolutionMinutes, 1);
            }
        }

        return view('dashboard', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'latestTickets',
            'categoryStats',
            'urgencyStats',
            'resolutionRate',
            'uniqueLocations',
            'avgResolutionMinutes'
        ));
    }
}