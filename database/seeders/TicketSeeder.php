<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $pelapor1 = User::where('email', 'pelapor1@demo.local')->firstOrFail();
        $pelapor2 = User::where('email', 'pelapor2@demo.local')->firstOrFail();
        $teknisi = User::where('email', 'teknisi@demo.local')->firstOrFail();

        $perangkat = Category::where('name', 'Perangkat')->firstOrFail();
        $jaringan = Category::where('name', 'Jaringan')->firstOrFail();
        $aplikasi = Category::where('name', 'Aplikasi')->firstOrFail();

        // TIKET 1 - OPEN
        $ticket1 = Ticket::create([
            'code' => 'TKT-DEMO-0001',
            'reporter_id' => $pelapor1->id,
            'category_id' => $jaringan->id,
            'title' => 'Internet gudang terputus',
            'location' => 'Gudang A',
            'description' => 'Koneksi internet di area Gudang A terputus dan tidak dapat digunakan.',
            'urgency' => 'TINGGI',
            'status' => 'OPEN',
            'resolution_note' => null,
        ]);

        TicketLog::create([
            'ticket_id' => $ticket1->id,
            'user_id' => $pelapor1->id,
            'old_status' => null,
            'new_status' => 'OPEN',
            'note' => 'Tiket dibuat.',
        ]);

        // TIKET 2 - IN_PROGRESS
        $ticket2 = Ticket::create([
            'code' => 'TKT-DEMO-0002',
            'reporter_id' => $pelapor1->id,
            'category_id' => $perangkat->id,
            'title' => 'Printer keuangan macet',
            'location' => 'Ruang Keuangan',
            'description' => 'Printer di Ruang Keuangan sering macet ketika digunakan untuk mencetak dokumen.',
            'urgency' => 'SEDANG',
            'status' => 'IN_PROGRESS',
            'resolution_note' => null,
        ]);

        TicketLog::create([
            'ticket_id' => $ticket2->id,
            'user_id' => $pelapor1->id,
            'old_status' => null,
            'new_status' => 'OPEN',
            'note' => 'Tiket dibuat.',
        ]);

        TicketLog::create([
            'ticket_id' => $ticket2->id,
            'user_id' => $teknisi->id,
            'old_status' => 'OPEN',
            'new_status' => 'IN_PROGRESS',
            'note' => 'Tiket mulai ditangani oleh teknisi.',
        ]);

        // TIKET 3 - RESOLVED
        $ticket3 = Ticket::create([
            'code' => 'TKT-DEMO-0003',
            'reporter_id' => $pelapor2->id,
            'category_id' => $aplikasi->id,
            'title' => 'Aplikasi absensi gagal',
            'location' => 'Kantor Utama',
            'description' => 'Aplikasi absensi tidak dapat digunakan untuk melakukan pencatatan kehadiran.',
            'urgency' => 'RENDAH',
            'status' => 'RESOLVED',
            'resolution_note' => 'Aplikasi telah dikonfigurasi ulang dan dapat digunakan kembali.',
        ]);

        TicketLog::create([
            'ticket_id' => $ticket3->id,
            'user_id' => $pelapor2->id,
            'old_status' => null,
            'new_status' => 'OPEN',
            'note' => 'Tiket dibuat.',
        ]);

        TicketLog::create([
            'ticket_id' => $ticket3->id,
            'user_id' => $teknisi->id,
            'old_status' => 'OPEN',
            'new_status' => 'IN_PROGRESS',
            'note' => 'Tiket mulai ditangani oleh teknisi.',
        ]);

        TicketLog::create([
            'ticket_id' => $ticket3->id,
            'user_id' => $teknisi->id,
            'old_status' => 'IN_PROGRESS',
            'new_status' => 'RESOLVED',
            'note' => 'Aplikasi telah dikonfigurasi ulang dan dapat digunakan kembali.',
        ]);

        // TIKET 4 - OPEN
        $ticket4 = Ticket::create([
            'code' => 'TKT-DEMO-0004',
            'reporter_id' => $pelapor2->id,
            'category_id' => $perangkat->id,
            'title' => 'Scanner barcode tidak terbaca',
            'location' => 'Gudang B',
            'description' => 'Scanner barcode di Gudang B tidak dapat membaca barcode barang.',
            'urgency' => 'SEDANG',
            'status' => 'OPEN',
            'resolution_note' => null,
        ]);

        TicketLog::create([
            'ticket_id' => $ticket4->id,
            'user_id' => $pelapor2->id,
            'old_status' => null,
            'new_status' => 'OPEN',
            'note' => 'Tiket dibuat.',
        ]);

        // TIKET 5 - OPEN
        $ticket5 = Ticket::create([
            'code' => 'TKT-DEMO-0005',
            'reporter_id' => $pelapor2->id,
            'category_id' => $aplikasi->id,
            'title' => 'ERP lambat',
            'location' => 'Kantor Operasional',
            'description' => 'Sistem ERP berjalan lambat ketika digunakan untuk mengakses data operasional.',
            'urgency' => 'TINGGI',
            'status' => 'OPEN',
            'resolution_note' => null,
        ]);

        TicketLog::create([
            'ticket_id' => $ticket5->id,
            'user_id' => $pelapor2->id,
            'old_status' => null,
            'new_status' => 'OPEN',
            'note' => 'Tiket dibuat.',
        ]);

        // TIKET 6 - RESOLVED
        $ticket6 = Ticket::create([
            'code' => 'TKT-DEMO-0006',
            'reporter_id' => $pelapor1->id,
            'category_id' => $jaringan->id,
            'title' => 'Wi-Fi ruang rapat tidak stabil',
            'location' => 'Ruang Rapat',
            'description' => 'Koneksi Wi-Fi di Ruang Rapat sering terputus ketika digunakan.',
            'urgency' => 'SEDANG',
            'status' => 'RESOLVED',
            'resolution_note' => 'Access point telah dikonfigurasi ulang dan koneksi kembali stabil.',
        ]);

        TicketLog::create([
            'ticket_id' => $ticket6->id,
            'user_id' => $pelapor1->id,
            'old_status' => null,
            'new_status' => 'OPEN',
            'note' => 'Tiket dibuat.',
        ]);

        TicketLog::create([
            'ticket_id' => $ticket6->id,
            'user_id' => $teknisi->id,
            'old_status' => 'OPEN',
            'new_status' => 'IN_PROGRESS',
            'note' => 'Tiket mulai ditangani oleh teknisi.',
        ]);

        TicketLog::create([
            'ticket_id' => $ticket6->id,
            'user_id' => $teknisi->id,
            'old_status' => 'IN_PROGRESS',
            'new_status' => 'RESOLVED',
            'note' => 'Access point telah dikonfigurasi ulang dan koneksi kembali stabil.',
        ]);
    }
}