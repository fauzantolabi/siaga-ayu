<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #435ebe;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 18px;
            color: #435ebe;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 11px;
            color: #666;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 11px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        .agenda-section {
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #435ebe;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #999;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            background-color: #e9ecef;
            color: #333;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>📋 LAPORAN AGENDA</h1>
        <p>Siaga Ayu - Sistem Informasi Agenda Indramayu</p>
    </div>

    {{-- Info Filter --}}
    <div class="info-row">
        <div><span class="info-label">Tanggal Laporan:</span> {{ $selectedDate->translatedFormat('l, d F Y') }}</div>
        <div><span class="info-label">Dicetak pada:</span> {{ now()->translatedFormat('d F Y H:i') }}</div>
    </div>
    <div class="info-row">
        <div><span class="info-label">User:</span> {{ $user->fullname }} ({{ $user->role->role_name }})</div>
    </div>

    {{-- Agendas --}}
    @if($agendas->isEmpty())
        <div class="no-data">
            ℹ️ Tidak ada agenda untuk tanggal yang dipilih
        </div>
    @else
        @if($user->role->role_name === 'Admin')
            {{-- GROUP BY PERANGKAT DAERAH (UNTUK ADMIN) --}}
            @foreach($agendas as $pdName => $agendasByPD)
                <div class="agenda-section">
                    <div class="section-title">{{ $pdName }}</div>

                    @if($agendasByPD->isEmpty())
                        <div class="no-data">Tidak ada agenda</div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jam</th>
                                    <th>Nama Agenda</th>
                                    <th>Tempat</th>
                                    <th>Jabatan</th>
                                    <th>Pakaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agendasByPD as $index => $agenda)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $agenda->jam_mulai ? $agenda->jam_mulai->format('H:i') : '-' }}</td>
                                        <td><strong>{{ $agenda->nama_agenda }}</strong></td>
                                        <td>{{ $agenda->tempat ?? '-' }}</td>
                                        <td>
                                            @if($agenda->jabatans->isNotEmpty())
                                                @foreach($agenda->jabatans as $jabatan)
                                                    <span class="badge">{{ $jabatan->nama_jabatan }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $agenda->pakaian->nama_pakaian ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endforeach
        @else
            {{-- FLAT LIST (UNTUK USER) --}}
            <div class="agenda-section">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jam</th>
                            <th>Nama Agenda</th>
                            <th>Tempat</th>
                            <th>Pakaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agendas as $index => $agenda)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $agenda->jam_mulai ? $agenda->jam_mulai->format('H:i') : '-' }}</td>
                                <td><strong>{{ $agenda->nama_agenda }}</strong></td>
                                <td>{{ $agenda->tempat ?? '-' }}</td>
                                <td>{{ $agenda->pakaian->nama_pakaian ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    {{-- Footer --}}
    <div class="footer">
        <p>Dokumen ini di-generate secara otomatis oleh Siaga Ayu</p>
    </div>
</body>
</html>
