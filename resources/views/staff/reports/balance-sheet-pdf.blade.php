<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
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
            border: 1px solid #000;
            padding: 5px;
        }
        th {
            background-color: #f0f0f0;
        }
        .text-right {
            text-align: right;
        }
        .text-bold {
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title }}</h2>
        <p>Per {{ $date }}</p>
    </div>

    <table>
        <tr>
            <th width="40%">AKTIVA</th>
            <th width="30%" class="text-right">JUMLAH</th>
            <th width="40%">PASIVA</th>
            <th width="30%" class="text-right">JUMLAH</th>
        </tr>
        
        <!-- Aktiva Lancar -->
        <tr>
            <td colspan="2" class="text-bold">Aktiva Lancar</td>
            <td colspan="2" class="text-bold">Kewajiban Lancar</td>
        </tr>
        @foreach($aktivaLancar as $account)
        <tr>
            <td>{{ $account->name }}</td>
            <td class="text-right">{{ number_format($account->balance, 0, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td>Total Aktiva Lancar</td>
            <td class="text-right">{{ number_format($totalAktivaLancar, 0, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>

        <!-- Aktiva Tetap -->
        <tr>
            <td colspan="2" class="text-bold">Aktiva Tetap</td>
            <td colspan="2" class="text-bold">Kewajiban Jangka Panjang</td>
        </tr>
        @foreach($aktivaTetap as $account)
        <tr>
            <td>{{ $account->name }}</td>
            <td class="text-right">{{ number_format($account->balance, 0, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td>Total Aktiva Tetap</td>
            <td class="text-right">{{ number_format($totalAktivaTetap, 0, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>

        <!-- Total Aktiva -->
        <tr class="total-row">
            <td>Total Aktiva</td>
            <td class="text-right">{{ number_format($totalAktiva, 0, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>

        <!-- Kewajiban -->
        @foreach($kewajibanLancar as $account)
        <tr>
            <td></td>
            <td></td>
            <td>{{ $account->name }}</td>
            <td class="text-right">{{ number_format($account->balance, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td></td>
            <td></td>
            <td>Total Kewajiban Lancar</td>
            <td class="text-right">{{ number_format($totalKewajibanLancar, 0, ',', '.') }}</td>
        </tr>

        @foreach($kewajibanJangkaPanjang as $account)
        <tr>
            <td></td>
            <td></td>
            <td>{{ $account->name }}</td>
            <td class="text-right">{{ number_format($account->balance, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td></td>
            <td></td>
            <td>Total Kewajiban Jangka Panjang</td>
            <td class="text-right">{{ number_format($totalKewajibanJangkaPanjang, 0, ',', '.') }}</td>
        </tr>

        <!-- Modal -->
        <tr>
            <td></td>
            <td></td>
            <td colspan="2" class="text-bold">Modal</td>
        </tr>
        @foreach($modal as $account)
        <tr>
            <td></td>
            <td></td>
            <td>{{ $account->name }}</td>
            <td class="text-right">{{ number_format($account->balance, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td></td>
            <td></td>
            <td>Total Modal</td>
            <td class="text-right">{{ number_format($totalModal, 0, ',', '.') }}</td>
        </tr>

        <!-- Total Pasiva -->
        <tr class="total-row">
            <td></td>
            <td></td>
            <td>Total Pasiva</td>
            <td class="text-right">{{ number_format($totalKewajibanModal, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html> 