<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan Baru</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { background: #4F46E5; color: white; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background: #4F46E5; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Laporan Pengaduan Warga Baru</h2>
        </div>
        
        <div class="content">
            <p>Halo Admin,</p>
            <p>Terdapat laporan pengaduan baru dari warga dengan rincian sebagai berikut:</p>
            
            <table style="width: 100%; margin-top: 15px; margin-bottom: 15px;">
                <tr>
                    <td style="width: 30%; font-weight: bold; padding: 5px 0;">Nama Pelapor</td>
                    <td>: {{ $complaint->user->name }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 5px 0;">Judul Laporan</td>
                    <td>: {{ $complaint->title }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 5px 0;">Tanggal</td>
                    <td>: {{ $complaint->created_at->format('d M Y, H:i') }}</td>
                </tr>
            </table>

            <p><strong>Isi Laporan:</strong></p>
            <div style="background: #f9f9f9; padding: 15px; border-left: 4px solid #4F46E5; margin-bottom: 20px;">
                {{ $complaint->description }}
            </div>

            <p style="text-align: center;">
                <a href="{{ route('admin.pengaduan.show', $complaint->id) }}" class="btn">Lihat Detail Laporan</a>
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} SIRA - Sistem Informasi RT/RW. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
