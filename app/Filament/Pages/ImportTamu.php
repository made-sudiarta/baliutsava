<?php

namespace App\Filament\Pages;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;

class ImportTamu extends Page
{
    use WithFileUploads;

    protected static string|\BackedEnum|null $navigationIcon =
        'heroicon-o-arrow-up-tray';

    protected static ?string $navigationLabel = 'Impor Tamu';

    protected static ?string $title = 'Impor Tamu Undangan';

    protected string $view = 'filament.pages.import-tamu';

    public $file = null;

    public ?string $invitationId = null;

    public array $importSummary = [];

    public function getInvitationsProperty()
    {
        return Invitation::query()
            ->orderBy('title')
            ->get(['id', 'title']);
    }

    public function import(): void
    {
        
        $this->validate(
            [
                'invitationId' => ['required', 'exists:invitations,id'],
                'file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
            ],
            [
                'invitationId.required' => 'Silakan pilih undangan tujuan.',
                'invitationId.exists' => 'Undangan yang dipilih tidak ditemukan.',
                'file.required' => 'Silakan pilih file CSV terlebih dahulu.',
                'file.mimes' => 'File harus berformat CSV atau TXT.',
                'file.max' => 'Ukuran file maksimal 5 MB.',
            ]
        );

        $handle = fopen($this->file->getRealPath(), 'r');

        if ($handle === false) {
            $this->addError('file', 'File tidak dapat dibaca.');
            return;
        }

        
        $firstLine = fgets($handle);

        if ($firstLine === false) {
            fclose($handle);
            $this->addError('file', 'File CSV kosong.');
            return;
        }

        // Deteksi delimiter: koma, titik koma, atau tab.
        $delimiters = [
            ',' => substr_count($firstLine, ','),
            ';' => substr_count($firstLine, ';'),
            "\t" => substr_count($firstLine, "\t"),
        ];

        arsort($delimiters);
        $delimiter = array_key_first($delimiters);

        rewind($handle);

        $headers = fgetcsv($handle, 0, $delimiter, '"', '\\');

        if (! $headers) {
            fclose($handle);
            $this->addError('file', 'Header CSV tidak ditemukan.');
            return;
        }

        // Normalisasi nama kolom, termasuk BOM UTF-8.
        $headers = array_map(function ($header) {
            $header = preg_replace('/^\xEF\xBB\xBF/', '', (string) $header);
            $header = strtolower(trim($header));

            return preg_replace('/[^a-z0-9]/', '', $header);
        }, $headers);

        // Cocokkan berbagai variasi judul kolom.
        $aliases = [
            'nama' => 'name',
            'namatamu' => 'name',
            'namalengkap' => 'name',
            'name' => 'name',

            'nomorwhatsapp' => 'phone',
            'nomorwa' => 'phone',
            'whatsapp' => 'phone',
            'phone' => 'phone',
            'nomortelepon' => 'phone',
            'telepon' => 'phone',
            'nohp' => 'phone',
            'hp' => 'phone',

            'kuota' => 'guest_quota',
            'guestquota' => 'guest_quota',
            'jumlahorang' => 'guest_quota',
        ];

        $headers = array_map(
            fn ($header) => $aliases[$header] ?? $header,
            $headers
        );

        if (
            ! in_array('name', $headers, true)
            || ! in_array('phone', $headers, true)
        ) {
            fclose($handle);

            $this->addError(
                'file',
                'Kolom tidak dikenali. Gunakan header: Nama Tamu, Nomor WhatsApp, Kuota.'
            );

            return;
        }


        $created = 0;
        $skipped = 0;
        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle, 0, $delimiter, '"', '\\')) !== false) {
            $rowNumber++;

            if (count($row) !== count($headers)) {
                $skipped++;
                $errors[] = "Baris {$rowNumber}: jumlah kolom tidak sesuai.";
                continue;
            }

            $data = array_combine($headers, $row);

            $name = trim((string) ($data['name'] ?? ''));
            $phoneInput = trim((string) ($data['phone'] ?? ''));
            $quotaInput = trim((string) ($data['guest_quota'] ?? '1'));

            $phone = preg_replace('/\D+/', '', $phoneInput);

            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            } elseif (str_starts_with($phone, '8')) {
                $phone = '62' . $phone;
            }

            $validator = Validator::make([
                'name' => $name,
                'phone' => $phone,
                'guest_quota' => $quotaInput === '' ? 1 : $quotaInput,
            ], [
                'name' => ['required', 'string', 'max:100'],
                'phone' => ['required', 'regex:/^62[0-9]{8,13}$/'],
                'guest_quota' => ['required', 'integer', 'min:1', 'max:10'],
            ]);

            if ($validator->fails()) {
                $skipped++;
                $errors[] = "Baris {$rowNumber}: data nama, nomor, atau kuota tidak valid.";
                continue;
            }

            $name = trim($name);
            $quota = (int) ($quotaInput === '' ? 1 : $quotaInput);

            $localPhone = '0' . substr($phone, 2);
            $shortPhone = substr($phone, 2);

            $duplicate = InvitationGuest::query()
                ->where('invitation_id', $this->invitationId)
                ->where('name', $name)
                ->whereIn('phone', array_unique([
                    $phone,
                    $localPhone,
                    $shortPhone,
                ]))
                ->exists();

            if ($duplicate) {
                $skipped++;
                $errors[] = "Baris {$rowNumber}: tamu {$name} sudah terdaftar.";
                continue;
            }

            InvitationGuest::create([
                'invitation_id' => $this->invitationId,
                'name' => $name,
                'phone' => $phone,
                'guest_quota' => $quota,
                'is_active' => true,
            ]);

            $created++;
        }

        fclose($handle);

        $this->importSummary = [
            'created' => $created,
            'skipped' => $skipped,
            'errors' => array_slice($errors, 0, 20),
            'total_errors' => count($errors),
        ];

        $this->reset('file');

        
    }

    public function downloadTemplate()
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            // BOM UTF-8 agar header terbaca dengan baik di Excel.
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Nama Tamu',
                'Nomor WhatsApp',
                'Kuota',
            ]);

            fclose($handle);
        }, 'template-import-tamu.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportGuests()
    {
        $this->validate([
            'invitationId' => [
                'required',
                'exists:invitations,id',
            ],
        ], [
            'invitationId.required' => 'Pilih undangan sebelum mengekspor tamu.',
            'invitationId.exists' => 'Undangan tidak ditemukan.',
        ]);

        $guests = InvitationGuest::query()
            ->where('invitation_id', $this->invitationId)
            ->orderBy('name')
            ->get([
                'name',
                'phone',
                'guest_quota',
            ]);

        $invitation = Invitation::findOrFail($this->invitationId);

        $filename = 'daftar-tamu-' . $invitation->slug . '.csv';

        return response()->streamDownload(function () use ($guests) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Nama Tamu',
                'Nomor WhatsApp',
                'Kuota',
            ]);

            foreach ($guests as $guest) {
                fputcsv($handle, [
                    $guest->name,
                    $guest->phone,
                    $guest->guest_quota,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

}