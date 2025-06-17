<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transaksi') }}
            </h2>
            <a href="{{ route('admin.transactions.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="overflow-x-auto">
                <form method="GET" class="mb-4 flex flex-wrap items-center gap-4">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nomor transaksi atau deskripsi..."
                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2 w-64">
                    </div>

                    <div>
                        <select name="type"
                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2">
                            <option value="">Semua Tipe</option>
                            <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>Umum</option>
                            <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>
                                Penyesuaian</option>
                            <option value="closing" {{ request('type') == 'closing' ? 'selected' : '' }}>Penutup
                            </option>
                        </select>
                    </div>

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-semibold">
                        Filter
                    </button>

                    <a href="{{ route('staff.transactions.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm font-semibold">
                        Reset
                    </a>
                </form>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. Transaksi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->transaction_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->reference_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $transaction->type === 'adjustment' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $transaction->type === 'closing' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $transaction->type === 'general' ? 'bg-blue-100 text-blue-800' : '' }}">

                                        @if ($transaction->type === 'adjustment')
                                            Penyesuaian
                                        @elseif ($transaction->type === 'closing')
                                            Penutup
                                        @else
                                            Umum
                                        @endif
                                    </span>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>
                                    {{-- @if ($transaction->type === 'general') --}}
                                    <a href="{{ route('admin.transactions.edit', $transaction) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    {{-- <form action="{{ route('admin.transactions.destroy', $transaction) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                                        </form> --}}
                                    {{-- @endif --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Tidak ada data transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
