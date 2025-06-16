<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Arus Kas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        .header p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 5px;
            border: 1px solid #000;
        }
        th {
            background-color: #f0f0f0;
        }
        .text-right {
            text-align: right;
        }
        .total {
            font-weight: bold;
        }
        .section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Arus Kas</h2>
        <p>Periode: {{ $month ? date('F Y', mktime(0, 0, 0, $month, 1, $year)) : $year }}</p>
    </div>

    <div class="section">
        <h3>Arus Kas dari Aktivitas Operasi</h3>
        <table>
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th style="width: 200px">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php $totalOperasi = 0; @endphp
                @foreach($operasi as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @php $totalOperasi += $item->total; @endphp
                @endforeach
                <tr class="total">
                    <td>Kas Neto dari Aktivitas Operasi</td>
                    <td class="text-right">{{ number_format($totalOperasi, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Arus Kas dari Aktivitas Investasi</h3>
        <table>
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th style="width: 200px">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php $totalInvestasi = 0; @endphp
                @foreach($investasi as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @php $totalInvestasi += $item->total; @endphp
                @endforeach
                <tr class="total">
                    <td>Kas Neto dari Aktivitas Investasi</td>
                    <td class="text-right">{{ number_format($totalInvestasi, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Arus Kas dari Aktivitas Pendanaan</h3>
        <table>
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th style="width: 200px">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPendanaan = 0; @endphp
                @foreach($pendanaan as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @php $totalPendanaan += $item->total; @endphp
                @endforeach
                <tr class="total">
                    <td>Kas Neto dari Aktivitas Pendanaan</td>
                    <td class="text-right">{{ number_format($totalPendanaan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Perubahan Kas</h3>
        <table>
            <tbody>
                <tr>
                    <td>Kenaikan (Penurunan) Kas</td>
                    <td class="text-right">{{ number_format($totalOperasi + $totalInvestasi + $totalPendanaan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Kas Awal Periode</td>
                    <td class="text-right">{{ number_format($kasAwal, 0, ',', '.') }}</td>
                </tr>
                <tr class="total">
                    <td>Kas Akhir Periode</td>
                    <td class="text-right">{{ number_format($kasAwal + $totalOperasi + $totalInvestasi + $totalPendanaan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html> 