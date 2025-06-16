<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Neraca</title>
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
        <h2>Laporan Neraca</h2>
        <p>Periode: {{ $month ? date('F Y', mktime(0, 0, 0, $month, 1, $year)) : $year }}</p>
    </div>

    <div class="section">
        <h3>Aktiva</h3>
        <table>
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th style="width: 200px">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php $totalAktiva = 0; @endphp
                @foreach($aktiva as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @php $totalAktiva += $item->total; @endphp
                @endforeach
                <tr class="total">
                    <td>Total Aktiva</td>
                    <td class="text-right">{{ number_format($totalAktiva, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Pasiva</h3>
        <table>
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th style="width: 200px">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPasiva = 0; @endphp
                @foreach($pasiva as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @php $totalPasiva += $item->total; @endphp
                @endforeach
                <tr class="total">
                    <td>Total Pasiva</td>
                    <td class="text-right">{{ number_format($totalPasiva, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html> 