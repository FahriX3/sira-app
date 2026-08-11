<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar - {{ $letter->letter_type }}</title>
    <style>
        @page { margin: 2.5cm; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header h3 {
            margin: 2px 0;
            font-size: 14pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 10pt;
        }
        .surat-title {
            text-align: center;
            margin: 30px 0 20px;
        }
        .surat-title h3 {
            font-size: 14pt;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
            letter-spacing: 1px;
        }
        .surat-title p {
            font-size: 10pt;
            margin: 4px 0 0;
        }
        .content { margin: 20px 0; }
        .content p { text-align: justify; margin-bottom: 10px; }
        table.data-diri {
            margin: 15px 0;
            border-collapse: collapse;
        }
        table.data-diri td {
            padding: 3px 0;
            vertical-align: top;
        }
        table.data-diri td:first-child {
            width: 150px;
        }
        table.data-diri td:nth-child(2) {
            width: 15px;
            text-align: center;
        }
        .signature {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 200px;
        }
        .signature-line {
            margin-top: 70px;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
        }
        .clear { clear: both; }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="header">
        <h2>Rukun Tetangga 005 / Rukun Warga 002</h2>
        <h3>Surat Pengantar</h3>
        <p>Sekretariat: Jl. Merdeka No. 1, RT 005/RW 002</p>
    </div>

    <!-- Judul Surat -->
    <div class="surat-title">
        <h3>{{ $letter->letter_type }}</h3>
        <p>No: {{ str_pad($letter->id, 3, '0', STR_PAD_LEFT) }}/SP-RT/{{ \Carbon\Carbon::parse($letter->created_at)->format('m/Y') }}</p>
    </div>

    <!-- Isi Surat -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Ketua RT 005 / RW 002, dengan ini menerangkan bahwa:</p>

        <table class="data-diri">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td><strong>{{ $letter->user->name }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $letter->user->nik }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $letter->user->email }}</td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td>:</td>
                <td>{{ $letter->user->phone ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $letter->user->address ?? '-' }}</td>
            </tr>
        </table>

        <p>Adalah benar warga kami yang berdomisili di alamat tersebut di atas.</p>

        <p><strong>Keperluan:</strong><br>{{ $letter->purpose }}</p>

        <p>Demikian surat pengantar ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <p>{{ now()->locale('id')->translatedFormat('d F Y') }}</p>
        <p>Ketua RT 005/RW 002</p>
        <div class="signature-line"></div>
        <p><strong><u>Pak RT Ahmad Sudrajat</u></strong></p>
    </div>

    <div class="clear"></div>
</body>
</html>
