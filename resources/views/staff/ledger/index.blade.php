<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buku Besar') }}
        </h2>
    </x-slot>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <form method="GET" class="mb-4 flex flex-wrap items-center gap-4">
                            <div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nomor transaksi atau deskripsi..."
                                    class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2 w-64">
                            </div>
                        
                            <div>
                                <select name="type" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2">
                                    <option value="">Semua Tipe</option>
                                    <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>Umum</option>
                                    <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Penyesuaian</option>
                                    <option value="closing" {{ request('type') == 'closing' ? 'selected' : '' }}>Penutup</option>
                                </select>
                            </div>
                        
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-semibold">
                                Filter
                            </button>
                        
                            <a href="{{ route('admin.transactions.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm font-semibold">
                                Reset
                            </a>
                        </form>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Akun</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($accounts as $account)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $account->code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $account->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ ucfirst($account->category->name) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <a href="{{ route('staff.ledger.show', $account) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                                Lihat Buku Besar
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Tidak ada akun yang tersedia
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 