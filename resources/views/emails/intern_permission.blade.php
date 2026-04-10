<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pengajuan Izin Magang</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td, a { font-family: Arial, Helvetica, sans-serif !important; }
    </style>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #F3F4F6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed; background-color: #F3F4F6; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
                    <!-- Header Accent -->
                    <tr>
                        <td style="background-color: #ED1E28; height: 6px;"></td>
                    </tr>
                    
                    <!-- Header Title -->
                    <tr>
                        <td style="padding: 40px 40px 20px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #111827; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">Pengajuan Izin Masuk</h1>
                            <p style="margin: 8px 0 0 0; color: #6B7280; font-size: 15px;">Dibutuhkan peninjauan persetujuan dari Anda</p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 10px 40px 30px 40px;">
                            <p style="margin: 0 0 20px 0; color: #374151; font-size: 16px; line-height: 1.6;">
                                Halo <strong>Bapak/Ibu Mentor</strong>,<br><br>
                                Salah satu peserta magang di bawah bimbingan Anda baru saja mengirimkan permohonan izin ketidakhadiran kerja. Harap tinjau detail pengajuan berikut ini:
                            </p>
                            
                            <!-- Information Table -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 8px; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="35%" style="padding: 8px 0; color: #6B7280; font-size: 14px; font-weight: 600;">Nama Lengkap</td>
                                                <td width="65%" style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 700;">{{ $internUser->name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6B7280; font-size: 14px; font-weight: 600; border-top: 1px solid #E5E7EB;">Instansi</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 700; border-top: 1px solid #E5E7EB;">{{ $internUser->studentProfile->university ?? ($internUser->studentProfile->institution ?? '-') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6B7280; font-size: 14px; font-weight: 600; border-top: 1px solid #E5E7EB;">Jenis Izin</td>
                                                <td style="padding: 8px 0; border-top: 1px solid #E5E7EB;">
                                                    <span style="display: inline-block; padding: 4px 10px; background-color: {{ $permissionData['permit_type'] === 'full' ? '#EEF2FF' : '#FFFBEB' }}; color: {{ $permissionData['permit_type'] === 'full' ? '#4F46E5' : '#D97706' }}; font-size: 12px; font-weight: 700; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        {{ $permissionData['permit_type'] === 'full' ? 'Izin Seharian' : 'Izin Sementara' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6B7280; font-size: 14px; font-weight: 600; border-top: 1px solid #E5E7EB;">Waktu Izin</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 700; border-top: 1px solid #E5E7EB;">{{ $permissionData['duration_text'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 12px 0 8px 0; color: #6B7280; font-size: 14px; font-weight: 600; border-top: 1px solid #E5E7EB; vertical-align: top;">Keterangan</td>
                                                <td style="padding: 12px 0 8px 0; color: #111827; font-size: 14px; line-height: 1.5; border-top: 1px solid #E5E7EB; vertical-align: top; font-style: italic;">"{{ $permissionData['reason'] }}"</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Call to Action -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('mentor.dashboard') }}" style="display: inline-block; background-color: #ED1E28; color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 700; padding: 14px 32px; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Tinjau di Dashboard Anda</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin: 30px 0 0 0; color: #6B7280; font-size: 14px; line-height: 1.6; text-align: center;">
                                Silakan akses portal Dashboard Anda untuk melihat riwayat absensi atau menangani izin peserta didik.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F9FAFB; padding: 24px 40px; border-top: 1px solid #E5E7EB; text-align: center;">
                            <p style="margin: 0; color: #9CA3AF; font-size: 12px; line-height: 1.6;">
                                Pesan ini di-generate secara otomatis oleh sistem<br>
                                <strong>Aplikasi Monitoring Magang Telkom Witel Semarang</strong><br>
                                © {{ date('Y') }} PT. Telekomunikasi Indonesia, Tbk.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
