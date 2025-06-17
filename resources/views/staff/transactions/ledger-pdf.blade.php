<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Buku Besar</title>
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
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Buku Besar</h2>
        <p>{{ $account->code }} - {{ $account->name }}</p>
        <p>Periode: {{ $month ? date('F Y', mktime(0, 0, 0, $month, 1, $year)) : $year }}</p>
    </div>

    <div class="mb-4">
        <p>Saldo Awal: Rp {{ number_format($saldoAwal, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                    <td>{{ $transaction->transaction_number }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td class="text-right">{{ $transaction->debit_amount ? number_format($transaction->debit_amount, 0, ',', '.') : '' }}</td>
                    <td class="text-right">{{ $transaction->credit_amount ? number_format($transaction->credit_amount, 0, ',', '.') : '' }}</td>
                    <td class="text-right">{{ number_format($transaction->saldo, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi untuk periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html> 