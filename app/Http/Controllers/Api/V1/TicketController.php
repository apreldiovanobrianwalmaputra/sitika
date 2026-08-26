<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Ticket::with([
            'category',
            'reporter',
        ]);

        // Pelapor hanya dapat melihat tiket sendiri
        if ($user->role === 'PELAPOR') {
            $query->where(
                'reporter_id',
                $user->id
            );
        }

        // q = pencarian kode atau judul
        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where(
                    'code',
                    'like',
                    "%{$search}%"
                )->orWhere(
                    'title',
                    'like',
                    "%{$search}%"
                );
            });
        }

        // kategori berdasarkan nama
        if ($request->filled('category')) {
            $category = $request->category;

            $query->whereHas(
                'category',
                function ($q) use ($category) {
                    $q->where(
                        'name',
                        $category
                    );
                }
            );
        }

        if ($request->filled('urgency')) {
            $query->where(
                'urgency',
                $request->urgency
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $tickets = $query
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data tiket berhasil diambil.',
            'data' => $tickets,
        ], 200);
    }


    public function show(
        Request $request,
        Ticket $ticket
    ) {
        $user = $request->user();

        if (
            $user->role === 'PELAPOR' &&
            $ticket->reporter_id !== $user->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke tiket ini.',
            ], 403);
        }

        $ticket->load([
            'category',
            'reporter',
            'logs.user',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Detail tiket berhasil diambil.',
            'data' => $ticket,
        ], 200);
    }


    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'PELAPOR') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pelapor yang dapat membuat tiket.',
            ], 403);
        }

        $validator = Validator::make(
            $request->all(),
            [
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
            ],
            [
                'category_id.required' =>
                    'Kategori wajib dipilih.',

                'category_id.exists' =>
                    'Kategori tidak valid.',

                'title.required' =>
                    'Judul wajib diisi.',

                'location.required' =>
                    'Lokasi wajib diisi.',

                'description.required' =>
                    'Deskripsi wajib diisi.',

                'urgency.required' =>
                    'Urgensi wajib dipilih.',

                'urgency.in' =>
                    'Urgensi tidak valid.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $ticket = DB::transaction(
            function () use ($validated, $user) {

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
                    $lastNumber =
                        (int) substr(
                            $lastTicket->code,
                            -4
                        );

                    $nextNumber =
                        $lastNumber + 1;
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
                    'reporter_id' => $user->id,
                    'category_id' =>
                        $validated['category_id'],
                    'title' =>
                        $validated['title'],
                    'location' =>
                        $validated['location'],
                    'description' =>
                        $validated['description'],
                    'urgency' =>
                        $validated['urgency'],
                    'status' => 'OPEN',
                    'resolution_note' => null,
                ]);

                TicketLog::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $user->id,
                    'old_status' => null,
                    'new_status' => 'OPEN',
                    'note' => 'Tiket dibuat.',
                ]);

                return $ticket;
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil dibuat.',
            'data' => [
                'code' => $ticket->code,
                'status' => $ticket->status,
            ],
        ], 201);
    }


    public function updateStatus(
        Request $request,
        Ticket $ticket
    ) {
        $user = $request->user();

        if ($user->role !== 'TEKNISI') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya teknisi yang dapat mengubah status.',
            ], 403);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'status' => [
                    'required',
                    Rule::in([
                        'IN_PROGRESS',
                        'RESOLVED',
                    ]),
                ],

                'resolution_note' => [
                    Rule::requiredIf(
                        $request->status === 'RESOLVED'
                    ),
                    'nullable',
                    'string',
                    'min:10',
                ],
            ],
            [
                'status.required' =>
                    'Status wajib diisi.',

                'status.in' =>
                    'Status tidak valid.',

                'resolution_note.required' =>
                    'Catatan penyelesaian wajib diisi.',

                'resolution_note.min' =>
                    'Catatan penyelesaian minimal 10 karakter.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $oldStatus = $ticket->status;
        $newStatus = $validated['status'];

        $validTransition =
            (
                $oldStatus === 'OPEN' &&
                $newStatus === 'IN_PROGRESS'
            )
            ||
            (
                $oldStatus === 'IN_PROGRESS' &&
                $newStatus === 'RESOLVED'
            );

        if (!$validTransition) {
            return response()->json([
                'success' => false,
                'message' =>
                    "Perubahan status dari {$oldStatus} ke {$newStatus} tidak diperbolehkan.",
            ], 422);
        }

        DB::transaction(
            function () use (
                $ticket,
                $user,
                $oldStatus,
                $newStatus,
                $validated
            ) {

                $ticket->status = $newStatus;

                if ($newStatus === 'RESOLVED') {
                    $ticket->resolution_note =
                        $validated['resolution_note'];
                }

                $ticket->save();

                TicketLog::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $user->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,

                    'note' =>
                        $newStatus === 'RESOLVED'
                            ? $validated['resolution_note']
                            : 'Tiket mulai ditangani oleh teknisi.',
                ]);
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'Status tiket berhasil diperbarui.',
            'data' => [
                'code' => $ticket->code,
                'status' => $ticket->status,
                'resolution_note' =>
                    $ticket->resolution_note,
            ],
        ], 200);
    }
}