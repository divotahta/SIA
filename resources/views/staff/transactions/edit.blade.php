<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaksi') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('staff.transactions.update', $transaction) }}" method="POST" id="transactionForm">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="transaction_date" class="block text-sm font-medium text-gray-700">Tanggal Transaksi</label>
                    <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    @error('transaction_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('description', $transaction->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Detail Transaksi</h3>
                    <div id="transactionDetails">
                        @foreach($transaction->details as $index => $detail)
                            <div class="transaction-detail border-b pb-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Akun</label>
                                        <select name="details[{{ $index }}][account_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                            <option value="">Pilih Akun</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ old("details.{$index}.account_id", $detail->account_id) == $account->id ? 'selected' : '' }}>
                                                    {{ $account->code }} - {{ $account->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Debit</label>
                                        <input type="number" name="details[{{ $index }}][debit]" value="{{ old("details.{$index}.debit", $detail->debit) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" min="0" step="0.01">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kredit</label>
                                        <input type="number" name="details[{{ $index }}][credit]" value="{{ old("details.{$index}.credit", $detail->credit) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" min="0" step="0.01">
                                    </div>
                                </div>
                                @if($index > 0)
                                    <button type="button" class="mt-2 text-red-600 hover:text-red-900 remove-detail">Hapus Detail</button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="addDetail" class="mt-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Tambah Detail
                    </button>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('staff.transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionDetails = document.getElementById('transactionDetails');
            const addDetailButton = document.getElementById('addDetail');
            let detailCount = {{ count($transaction->details) }};

            addDetailButton.addEventListener('click', function() {
                const detailDiv = document.createElement('div');
                detailDiv.className = 'transaction-detail border-b pb-4 mb-4';
                detailDiv.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Akun</label>
                            <select name="details[${detailCount}][account_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Pilih Akun</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Debit</label>
                            <input type="number" name="details[${detailCount}][debit]" value="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" min="0" step="0.01">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kredit</label>
                            <input type="number" name="details[${detailCount}][credit]" value="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" min="0" step="0.01">
                        </div>
                    </div>
                    <button type="button" class="mt-2 text-red-600 hover:text-red-900 remove-detail">Hapus Detail</button>
                `;

                transactionDetails.appendChild(detailDiv);
                detailCount++;

                // Add event listener to remove button
                detailDiv.querySelector('.remove-detail').addEventListener('click', function() {
                    detailDiv.remove();
                });
            });

            // Add event listeners to initial remove buttons
            document.querySelectorAll('.remove-detail').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.transaction-detail').remove();
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 