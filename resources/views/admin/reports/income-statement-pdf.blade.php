<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Laba Rugi</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Laba Rugi</h2>
        <p>Periode: {{ $month ? date('F Y', mktime(0, 0, 0, $month, 1, $year)) : $year }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th style="width: 200px">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2"><strong>Pendapatan</strong></td>
            </tr>
            @php $totalPendapatan = 0; @endphp
            @foreach($pendapatan as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td class="text-right">{{ number_format($item->total, 0, ',', '.') }}</td>
            </tr>
            @php $totalPendapatan += $item->total; @endphp
            @endforeach
            <tr class="total">
                <td>Total Pendapatan</td>
                <td class="text-right">{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="2"><strong>Beban</strong></td>
            </tr>
            @php $totalBeban = 0; @endphp
            @foreach($beban as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td class="text-right">{{ number_format($item->total, 0, ',', '.') }}</td>
            </tr>
            @php $totalBeban += $item->total; @endphp
            @endforeach
            <tr class="total">
                <td>Total Beban</td>
                <td class="text-right">{{ number_format($totalBeban, 0, ',', '.') }}</td>
            </tr>

            <tr class="total">
                <td>Laba (Rugi)</td>
                <td class="text-right">{{ number_format($totalPendapatan - $totalBeban, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html> 