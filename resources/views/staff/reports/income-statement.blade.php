<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Laba Rugi') }}
            </h2>
            <div>
                <form action="{{ route('staff.reports.income-statement') }}" method="GET" class="flex items-center space-x-4">
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                        <select name="year" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}" {{ request('year', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tampilkan
                        </button>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('staff.reports.income-statement', array_merge(request()->query(), ['export' => 'pdf'])) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Export PDF
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold">Laporan Laba Rugi</h1>
                <p class="text-gray-600">Periode Tahun {{ request('year', date('Y')) }}</p>
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
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Pendapatan</td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-right"></td>
                        </tr>
                        @foreach($revenues as $revenue)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500 pl-8">{{ $revenue->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">
                                    Rp {{ number_format($revenue->balance, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Pendapatan</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                Rp {{ number_format($revenues->sum('balance'), 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Beban</td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-right"></td>
                        </tr>
                        @foreach($expenses as $expense)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500 pl-8">{{ $expense->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">
                                    Rp {{ number_format($expense->balance, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Beban</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                Rp {{ number_format($expenses->sum('balance'), 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr class="bg-gray-100">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Laba (Rugi) Bersih</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                Rp {{ number_format($revenues->sum('balance') - $expenses->sum('balance'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> 