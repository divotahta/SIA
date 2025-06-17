<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Akun') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('admin.accounts.edit', $account) }}" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out flex items-center"
                    data-aos="fade-left">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Akun
                </a>
                <a href="{{ route('admin.accounts.index') }}" 
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out flex items-center"
                    data-aos="fade-left" data-aos-delay="100">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Card Informasi Akun -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" data-aos="fade-up">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Akun</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">Kode Akun</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $account->code }}</dd>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">Nama Akun</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $account->name }}</dd>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $account->category->name }} ({{ $account->category->code }})</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Saldo</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">Saldo Saat Ini</dt>
                                    <dd class="mt-1 text-2xl font-bold text-gray-900">Rp {{ number_format($account->balance, 0, ',', '.') }}</dd>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $account->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $account->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Riwayat Transaksi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" data-aos="fade-up" data-aos-delay="200">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Transaksi Terakhir</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No. Referensi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Debit
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kredit
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($account->transactionDetails as $detail)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $detail->transaction->transaction_date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $detail->transaction->reference_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $detail->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $detail->debit_amount > 0 ? 'Rp ' . number_format($detail->debit_amount, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $detail->credit_amount > 0 ? 'Rp ' . number_format($detail->credit_amount, 0, ',', '.') : '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Belum ada transaksi
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

    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</x-app-layout> 