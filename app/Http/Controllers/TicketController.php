<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Ticket::with([
            'category',
            'reporter'
        ]);

        // Pelapor hanya boleh melihat tiket miliknya
        if ($user->role === 'PELAPOR') {
            $query->where('reporter_id', $user->id);
        }

        // Pencarian berdasarkan kode atau judul
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('code', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%");

            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        // Filter urgensi
        if ($request->filled('urgency')) {
            $query->where(
                'urgency',
                $request->urgency
            );
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $tickets = $query
            ->latest()
            ->get();

        $categories = Category::orderBy('name')
            ->get();

        return view(
            'tickets.index',
            compact(
                'tickets',
                'categories'
            )
        );
    }

    public function show(Ticket $ticket)
    {
        $user = Auth::user();

        // Pelapor hanya boleh membuka tiket miliknya
        if (
            $user->role === 'PELAPOR' &&
            $ticket->reporter_id !== $user->id
        ) {
            abort(403);
        }

        $ticket->load([
            'category',
            'reporter',
            'logs.user',
        ]);

        return view('tickets.show', compact('ticket'));
    }

    public function create()
    {
        // Hanya PELAPOR yang boleh membuat tiket
        abort_unless(Auth::user()->role === 'PELAPOR', 403);

        $categories = Category::orderBy('name')->get();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Hanya PELAPOR yang boleh membuat tiket
        abort_unless(Auth::user()->role === 'PELAPOR', 403);

        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'location' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
            ],
            'urgency' => [
                'required',
                Rule::in([
                    'RENDAH',
                    'SEDANG',
                    'TINGGI',
                ]),
            ],
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',

            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',

            'location.required' => 'Lokasi wajib diisi.',
            'location.max' => 'Lokasi maksimal 255 karakter.',

            'description.required' => 'Deskripsi wajib diisi.',

            'urgency.required' => 'Urgensi wajib dipilih.',
            'urgency.in' => 'Urgensi tidak valid.',
        ]);

        $ticket = DB::transaction(function () use ($validated) {

            $date = now()->format('Ymd');

            $lastTicket = Ticket::where(
                'code',
                'like',
                "TKT-{$date}-%"
            )
                ->lockForUpdate()
                ->orderByDesc('code')
                ->first();

            if ($lastTicket) {
                $lastNumber = (int) substr(
                    $lastTicket->code,
                    -4
                );

                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $code = sprintf(
                'TKT-%s-%04d',
                $date,
                $nextNumber
            );

            $ticket = Ticket::create([
                'code' => $code,
                'reporter_id' => Auth::id(),
                'category_id' => $validated['category_id'],
                'title' => $validated['title'],
                'location' => $validated['location'],
                'description' => $validated['description'],
                'urgency' => $validated['urgency'],
                'status' => 'OPEN',
                'resolution_note' => null,
            ]);

            TicketLog::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'old_status' => null,
                'new_status' => 'OPEN',
                'note' => 'Tiket dibuat.',
            ]);

            return $ticket;
        });

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                "Tiket {$ticket->code} berhasil dibuat."
            );
    }
}