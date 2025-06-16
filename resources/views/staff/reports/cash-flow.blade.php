<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Arus Kas') }}
            </h2>
            <div>
                <a href="{{ route('staff.reports.cash-flow', ['year' => request('year'), 'month' => request('month'), 'export' => 'pdf']) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Export PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('staff.reports.cash-flow') }}" method="GET" class="mb-8">
                <div class="flex gap-4">
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                        <select name="year" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}" {{ request('year', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700">Bulan</label>
                        <select name="month" id="month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>

            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold">Laporan Arus Kas</h1>
                <p class="text-gray-600">
                    Periode {{ date('F Y', mktime(0, 0, 0, request('month', date('n')), 1, request('year', date('Y')))) }}
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Arus Kas dari Aktivitas Operasi</td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-right"></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Penerimaan Kas</td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-right"></td>
                        </tr>
                        @foreach($cashInflows as $inflow)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500 pl-8">{{ $inflow->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">
                                    Rp {{ number_format($inflow->balance, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Penerimaan Kas</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                Rp {{ number_format($cashInflows->sum('balance'), 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Pengeluaran Kas</td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-right"></td>
                        </tr>
                        @foreach($cashOutflows as $outflow)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500 pl-8">{{ $outflow->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">
                                    Rp {{ number_format($outflow->balance, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Pengeluaran Kas</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                Rp {{ number_format($cashOutflows->sum('balance'), 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr class="bg-gray-100">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Kas Neto dari Aktivitas Operasi</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                Rp {{ number_format($cashInflows->sum('balance') - $cashOutflows->sum('balance'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> 