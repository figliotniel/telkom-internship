<?php

namespace App\Services;

use App\Models\Internship;
use App\Models\Division;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class InternshipService
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function approve(Internship $internship, Division $division)
    {
        // Hardcoded Link dipindahkan ke config fallback
        $paktaLink = config('app.pakta_integritas_link', 'https://docs.google.com/document/d/1MYswMj78AfqPH9yBIeH8U9VBA5jDaRguTzwQX-9ARe8/edit?tab=t.0');

        $internship->documents()->create([
            'name' => 'Link Template Pakta Integritas',
            'type' => 'pakta_integritas',
            'file_path' => $paktaLink,
            'is_verified' => true
        ]);

        $internship->update([
            'status' => 'onboarding',
            'division_id' => $division->id,
            'mentor_id' => $division->mentor_id,
        ]);

        $this->sendEmail($internship, \App\Mail\InternshipApproved::class);
    }

    public function reject(Internship $internship)
    {
        $internship->update(['status' => 'rejected']);
        $this->sendEmail($internship, \App\Mail\InternshipRejected::class);
    }

    public function activate(Internship $internship, array $inductionData)
    {
        $message = 'Program magang berhasil diaktifkan. Mahasiswa kini berstatus Aktif dengan Mentor & Divisi terpilih.';

        $inviteLink = $this->telegramService->generateInviteLink();

        $updateData = ['status' => 'active'];
        if ($inviteLink) {
            $updateData['telegram_invite_link'] = $inviteLink;
        } else {
            $message .= ' (Peringatan: Gagal membuat link undangan Telegram).';
        }

        $internship->update($updateData);

        $inductionData['location'] = 'Ruang Kompeten Unit Shared Service & General Support Witel Semarang Jateng Utara Lantai 2 GMP Pahlawan, Jl. Pahlawan No. 10, Kota Semarang';
        $inductionData['activity'] = 'Induksi Peserta Magang & Pengambilan ID Card';

        $emailSent = $this->sendEmail($internship, \App\Mail\InternshipActive::class, [$internship, $inductionData]);

        if ($emailSent) {
            $message .= ' Email notifikasi telah antre dikirim.';
        } else {
            $message .= ' Namun email gagal dikirim (Cek konfigurasi SMTP Anda).';
        }

        return $message;
    }

    public function complete(Internship $internship, array $files)
    {
        // Remove old completion documents if re-uploading
        $internship->documents()->whereIn('type', ['sertifikat_kelulusan', 'laporan_penilaian_pkl', 'dokumen_kelulusan'])->delete();

        foreach ($files as $file) {
            $path = $file->store('documents/admin', 'public');
            $originalName = $file->getClientOriginalName();

            $internship->documents()->create([
                'type' => 'dokumen_kelulusan',
                'name' => $originalName,
                'file_path' => $path,
                'is_verified' => true
            ]);
        }

        $this->sendEmail($internship, \App\Mail\InternshipFinished::class);
    }

    /**
     * Helper to send queued emails safely
     */
    protected function sendEmail(Internship $internship, string $mailClass, array $args = []): bool
    {
        try {
            if ($internship->student && $internship->student->email) {
                $mailInstance = empty($args) ? new $mailClass($internship) : new $mailClass(...$args);
                Mail::to($internship->student->email)->queue($mailInstance);
                return true;
            }
        } catch (\Exception $e) {
            Log::error("Failed to send {$mailClass} email: " . $e->getMessage());
        }
        return false;
    }
}
