<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Neraca') }}
            </h2>
            <div>
                <a href="{{ route('staff.reports.balance-sheet', ['export' => 'pdf']) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Export PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold">Laporan Neraca</h1>
                <p class="text-gray-600">Per {{ date('d/m/Y') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Aktiva -->
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Aktiva</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($assets as $asset)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $asset->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 text-right">
                                            Rp {{ number_format($asset->balance, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Aktiva</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                        Rp {{ number_format($assets->sum('balance'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pasiva -->
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Pasiva</h2>
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
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Kewajiban</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 text-right"></td>
                                </tr>
                                @foreach($liabilities as $liability)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 pl-8">{{ $liability->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 text-right">
                                            Rp {{ number_format($liability->balance, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Kewajiban</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                        Rp {{ number_format($liabilities->sum('balance'), 0, ',', '.') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Modal</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 text-right"></td>
                                </tr>
                                @foreach($equities as $equity)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 pl-8">{{ $equity->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 text-right">
                                            Rp {{ number_format($equity->balance, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Modal</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                        Rp {{ number_format($equities->sum('balance'), 0, ',', '.') }}
                                    </td>
                                </tr>

                                <tr class="bg-gray-100">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Pasiva</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                        Rp {{ number_format($liabilities->sum('balance') + $equities->sum('balance'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 