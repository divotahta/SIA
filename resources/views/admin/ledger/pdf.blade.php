<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Buku Besar - {{ $account->code }} - {{ $account->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-info {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Buku Besar</h1>
    
    <div class="header-info">
        <p><strong>Akun:</strong> {{ $account->code }} - {{ $account->name }}</p>
        <p><strong>Periode:</strong> {{ $year }} {{ $month ? '- ' . date('F', mktime(0, 0, 0, $month, 1)) : '' }}</p>
        <p><strong>Saldo Awal:</strong> Rp {{ number_format($saldoAwal, 0, ',', '.') }}</p>
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
                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}</td>
                    <td>{{ $transaction->reference_number }}</td>
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