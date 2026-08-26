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

        // Aturan perubahan status yang diperbolehkan
        $validTransition =
            ($oldStatus === 'OPEN' &&
                $newStatus === 'IN_PROGRESS')
            ||
            ($oldStatus === 'IN_PROGRESS' &&
                $newStatus === 'RESOLVED');

        if (!$validTransition) {
            return back()->withErrors([
                'status' =>
                    "Perubahan status dari {$oldStatus} ke {$newStatus} tidak diperbolehkan.",
            ]);
        }

        DB::transaction(function () use (
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

            TicketLog::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'old_status' => $oldStatus,
                'new_status' => $newStatus,

                'note' => $newStatus === 'RESOLVED'
                    ? $validated['resolution_note']
                    : 'Tiket mulai ditangani oleh teknisi.',
            ]);
        });

        return redirect()
            ->route('tickets.show', $ticket)
            ->with(
                'success',
                'Status tiket berhasil diperbarui.'
            );
    }
}