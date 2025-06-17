<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Arus Kas') }}
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
            <form action="{{ route('staff.reports.cash-flow') }}" method="GET" class="mb-6">
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
                    <h3 class="text-lg font-semibold">Laporan Arus Kas</h3>
                    <p class="text-sm text-gray-600">
                        Periode: {{ request('month') ? date('F', mktime(0, 0, 0, request('month'), 1)) : 'Januari' }} - {{ request('month') ? date('F', mktime(0, 0, 0, request('month'), 1)) : 'Desember' }} {{ request('year', date('Y')) }}
                    </p>
                </div>

                <!-- Arus Kas dari Aktivitas Operasi -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-2">Arus Kas dari Aktivitas Operasi</h4>
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $totalOperasi = 0;
                            @endphp
                            @foreach($operasi as $item)
                                <tr>
                                    <td class="px-6 py-2 text-sm text-gray-900">{{ $item->name }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @php
                                    $totalOperasi += $item->total;
                                @endphp
                            @endforeach
                            <tr class="font-semibold">
                                <td class="px-6 py-2 text-sm text-gray-900">Kas Neto dari Aktivitas Operasi</td>
                                <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                    Rp {{ number_format($totalOperasi, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Arus Kas dari Aktivitas Investasi -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-2">Arus Kas dari Aktivitas Investasi</h4>
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $totalInvestasi = 0;
                            @endphp
                            @foreach($investasi as $item)
                                <tr>
                                    <td class="px-6 py-2 text-sm text-gray-900">{{ $item->name }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @php
                                    $totalInvestasi += $item->total;
                                @endphp
                            @endforeach
                            <tr class="font-semibold">
                                <td class="px-6 py-2 text-sm text-gray-900">Kas Neto dari Aktivitas Investasi</td>
                                <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                    Rp {{ number_format($totalInvestasi, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Arus Kas dari Aktivitas Pendanaan -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-2">Arus Kas dari Aktivitas Pendanaan</h4>
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $totalPendanaan = 0;
                            @endphp
                            @foreach($pendanaan as $item)
                                <tr>
                                    <td class="px-6 py-2 text-sm text-gray-900">{{ $item->name }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @php
                                    $totalPendanaan += $item->total;
                                @endphp
                            @endforeach
                            <tr class="font-semibold">
                                <td class="px-6 py-2 text-sm text-gray-900">Kas Neto dari Aktivitas Pendanaan</td>
                                <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                    Rp {{ number_format($totalPendanaan, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Kenaikan/Penurunan Kas -->
                <div class="mt-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="font-semibold">
                                <td class="px-6 py-2 text-sm text-gray-900">Kenaikan (Penurunan) Kas</td>
                                <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                    Rp {{ number_format($totalOperasi + $totalInvestasi + $totalPendanaan, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="font-semibold">
                                <td class="px-6 py-2 text-sm text-gray-900">Kas Awal Periode</td>
                                <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                    Rp {{ number_format($kasAwal, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="font-semibold">
                                <td class="px-6 py-2 text-sm text-gray-900">Kas Akhir Periode</td>
                                <td class="px-6 py-2 text-sm text-gray-900 text-right">
                                    Rp {{ number_format($kasAwal + $totalOperasi + $totalInvestasi + $totalPendanaan, 0, ',', '.') }}
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