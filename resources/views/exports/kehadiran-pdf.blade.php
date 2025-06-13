<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Hadir</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .top-header td {
            border: 1px solid black;
            padding: 5px;
        }
        .top-header .logo {
            text-align: center;
            width: 25%;
        }
        .top-header .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            width: 35%;
        }
        .top-header .meta td {
            font-weight: normal;
            font-size: 10px;
        }

        .meta-subtable td {
            padding: 3px;
            font-size: 10px;
        }

        .info-table {
            margin-top: 10px;
            border: 1px solid black;
        }
        .info-table th, .info-table td {
            border: 1px solid black;
            padding: 6px;
            font-size: 11px;
        }

        .attendance-table {
            margin-top: 5px;
        }

        .attendance-table th {
            background-color: #999;
            color: white;
            padding: 6px;
            text-align: center;
            font-size: 11px;
        }
        .attendance-table td {
            border: 1px solid black;
            padding: 6px;
            height: 50px;
            text-align: center;
            font-size: 11px;
        }

        .signature img {
            max-height: 45px;
        }
    </style>
</head>
<body>
@php use Illuminate\Support\Str; @endphp
<table class="top-header">
    <tr>
        <td class="logo">
            <img src="{{ public_path('logo/unhas.png') }}" alt="Logo" width="75"><br>
            <div style="font-size: 10px;"><br>UNIVERSITAS<br>HASANUDDIN</strong></div>
        </td>
        <td class="title">
            DAFTAR HADIR
        </td>
        <td class="meta" style="width: 40%;">
            <table class="meta-subtable" style="width: 100%;">
                <tr>
                    <td><strong>No. Dokumen</strong></td>
                    <td>{{ $rapat->noDokumen_rapat ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>No. Revisi</strong></td>
                    <td>{{ $rapat->noRevisi_rapat ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Tgl. Berlaku</strong></td>
                    <td>{{ \Carbon\Carbon::parse($rapat->tgl_berlaku_rapat)->locale('id')->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Halaman</strong></td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="info-table">
    <tr>
        <th colspan="2" style="width: 70%;"><strong>Agenda:</strong> {{ strtoupper($rapat->agenda_rapat) }}</th>
    </tr>
    <tr>
        <td style="width: 50%;"><strong>HARI/TANGGAL:</strong> {{ \Carbon\Carbon::parse($rapat->tanggal_rapat)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
        <td style="width: 50%;">
            <strong>Tempat:</strong>
            @if ($rapat->jenis_rapat === 'online')
                Online Meeting (Zoom/Microsoft Teams/Google Meet)
            @else
                {{ $rapat->lokasi_rapat }}
            @endif
        </td>
    </tr>
</table>

<table class="attendance-table" style="width: 100%;">
    <thead>
        <tr>
            <th style="width: 5%;">No.</th>
            <th style="width: 10%;">Nama</th>
            <th style="width: 15%;">NIP/NIK</th>
            <th style="width: 10%;">Unit Kerja</th>
            <th style="width: 10%;">Jabatan/Tugas</th>
            <th style="width: 10%;">Instansi</th>
            <th style="width: 10%;">No. Telepon</th>
            <th style="width: 10%;">Email</th>
            <th style="width: 10%;">Tanda Tangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kehadiran as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nip_nik }}</td>
                <td>{{ $item->unit_kerja }}</td>
                <td>{{ $item->jabatan_tugas }}</td>
                <td>{{ $item->instansi }}</td>
                <td>{{ $item->no_telepon }}</td>
                <td>{{ $item->email }}</td>
                <td class="signature">
                    @if (Str::startsWith($item->tanda_tangan, 'data:image'))
                        <img src="{{ $item->tanda_tangan }}" style="height: 60px;">
                    @elseif (file_exists(public_path('storage/' . $item->tanda_tangan)))
                        <img src="{{ public_path('storage/' . $item->tanda_tangan) }}" style="height: 60px;">
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<table style="width: 100%; margin-top: 30px;">
    <tr>
        <td style="width: 60%;"></td>
        <td style="width: 30%; text-align: left; font-size: 12px;">
            <div>{{ $rapat->penandatangan_jabatan ?? '-' }}</div>
            <br><br><br><br>
            <div><strong>{{ $rapat->penandatangan_nama ?? '-' }}</strong></div>
            <div>NIP {{ $rapat->penandatangan_nip ?? '-' }}</div>
        </td>
    </tr>
</table>


</body>
</html>
