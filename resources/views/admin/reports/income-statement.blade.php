<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Laba Rugi') }}
            </h2>
            <div class="flex space-x-4">
                <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Export PDF
                </button>
            </div>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <!-- Filter Form -->
            <form action="{{ route('admin.reports.income-statement') }}" method="GET" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                        <select name="year" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @for($i = date('Y'); $i >= date('Y')-4; $i--)
                                <option value="{{ $i }}" {{ request('year', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700">Bulan</label>
                        <select name="month" id="month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Bulan</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Filter
                        </button>
                    </div>
                </div>
            </form>

            <!-- Report Content -->
            <div class="mt-6">
                <div class="text-center mb-6">
                    <h3 class="text-lg font-semibold">Laporan Laba Rugi</h3>
                    <p class="text-sm text-gray-600">
                        Periode: {{ request('month') ? date('F', mktime(0, 0, 0, request('month'), 1)) : 'Januari' }} - {{ request('month') ? date('F', mktime(0, 0, 0, request('month'), 1)) : 'Desember' }} {{ request('year', date('Y')) }}
                    </p>
                </div>

                <!-- Pendapatan -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-2">Pendapatan</h4>
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $totalPendapatan = 0;
                            @endphp
                            @foreach($pendapatan as $item)
                                <tr>
                                    <td class="px-6 py-2 text-sm text-gray-900">{{ $item->name }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @php
                                    $totalPendapatan += $item->total;
                                @endphp
                            @endforeach
                            <tr class="font-semibold">
                                <td class="px-6 py-2 text-sm text-gray-900">Total Pendapatan</td>
                                <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Beban -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-2">Beban</h4>
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $totalBeban = 0;
                            @endphp
                            @foreach($beban as $item)
                                <tr>
                                    <td class="px-6 py-2 text-sm text-gray-900">{{ $item->name }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @php
                                    $totalBeban += $item->total;
                                @endphp
                            @endforeach
                            <tr class="font-semibold">
                                <td class="px-6 py-2 text-sm text-gray-900">Total Beban</td>
                                <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                    Rp {{ number_format($totalBeban, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Laba Rugi -->
                <div class="mt-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="font-semibold">
                                <td class="px-6 py-2 text-sm text-gray-900">Laba (Rugi) Bersih</td>
                                <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                    Rp {{ number_format($totalPendapatan - $totalBeban, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none;
            }
            .print-only {
                display: block;
            }
        }
    </style>
</x-app-layout> 