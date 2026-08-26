<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TicketStatusController extends Controller
{
    public function update(Request $request, Ticket $ticket)
    {
        // Hanya teknisi yang boleh mengubah status
        abort_unless(Auth::user()->role === 'TEKNISI', 403);

        $validated = $request->validate([
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
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',

            'resolution_note.required' =>
                'Catatan penyelesaian wajib diisi.',

            'resolution_note.min' =>
                'Catatan penyelesaian minimal 10 karakter.',
        ]);

        $oldStatus = $ticket->status;
        $newStatus = $validated['status'];

        $validTransition =
            ($oldStatus === 'OPEN' &&
                $newStatus === 'IN_PROGRESS')
            ||
            ($oldStatus === 'IN_PROGRESS' &&
                $newStatus === 'RESOLVED');

        if (!$validTransition) {

            $message =
                "Perubahan status dari {$oldStatus} ke {$newStatus} tidak diperbolehkan.";

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 422);
            }

            return back()->withErrors([
                'status' => $message,
            ]);
        }

        $log = DB::transaction(function () use (
            $ticket,
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

            return TicketLog::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'old_status' => $oldStatus,
                'new_status' => $newStatus,

                'note' => $newStatus === 'RESOLVED'
                    ? $validated['resolution_note']
                    : 'Tiket mulai ditangani oleh teknisi.',
            ]);
        });

        $log->load('user');

        // Response untuk AJAX
        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'message' =>
                    'Status tiket berhasil diperbarui.',

                'status' => $ticket->status,

                'resolution_note' =>
                    $ticket->resolution_note,

                'log' => [
                    'user' => $log->user->name,
                    'old_status' => $log->old_status,
                    'new_status' => $log->new_status,
                    'note' => $log->note,
                    'created_at' =>
                        $log->created_at
                            ->format('d/m/Y H:i'),
                ],
            ]);
        }

        // Tetap mendukung form biasa
        return redirect()
            ->route('tickets.show', $ticket)
            ->with(
                'success',
                'Status tiket berhasil diperbarui.'
            );
    }
}