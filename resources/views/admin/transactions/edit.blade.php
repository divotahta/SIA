<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="transaction-form" action="{{ route('admin.transactions.update', $transaction) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal -->
                            <div>
                                <label for="transaction_date"
                                    class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" name="transaction_date" id="transaction_date"
                                    value="{{ old('transaction_date', $transaction->transaction_date ? $transaction->transaction_date->format('Y-m-d') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                @error('transaction_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipe Transaksi -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Tipe
                                    Transaksi</label>
                                <select name="type" id="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="general"
                                        {{ old('type', $transaction->type) == 'general' ? 'selected' : '' }}>Umum
                                    </option>
                                    <option value="adjustment"
                                        {{ old('type', $transaction->type) == 'adjustment' ? 'selected' : '' }}>adjustment
                                    </option>
                                    <option value="closing"
                                        {{ old('type', $transaction->type) == 'closing' ? 'selected' : '' }}>Closing
                                    </option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Detail Transaksi -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Detail Transaksi</h3>
                            <div class="mt-4 space-y-4" id="transaction-details">
                                @foreach ($transaction->details as $index => $detail)
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Akun</label>
                                            <select name="details[{{ $index }}][account_id]" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="">Pilih Akun</option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}"
                                                        {{ $detail->account_id == $account->id ? 'selected' : '' }}>
                                                        {{ $account->code }} - {{ $account->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Debit</label>
                                            <input type="number" name="details[{{ $index }}][debit_amount]"
                                                step="0.01"
                                                value="{{ old("details.{$index}.debit_amount", $detail->debit_amount) }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Kredit</label>
                                            <input type="number" name="details[{{ $index }}][credit_amount]"
                                                step="0.01"
                                                value="{{ old("details.{$index}.credit_amount", $detail->credit_amount) }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                            <input type="text" name="details[{{ $index }}][description]"
                                                value="{{ old("details.{$index}.description", $detail->description) }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <button type="button"
                                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out"
                                                onclick="removeDetail(this)">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-detail"
                                class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Tambah Detail
                            </button>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.transactions.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addButton = document.getElementById('add-detail');
            const detailsContainer = document.getElementById('transaction-details');
            let detailCount = document.querySelectorAll('#transaction-details .grid').length;

            function createDetailRow() {
                const row = document.createElement('div');
                row.className = 'grid grid-cols-1 md:grid-cols-5 gap-4 items-end';
                row.innerHTML = `
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Akun</label>
                        <select name="details[${detailCount}][account_id]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih Akun</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Debit</label>
                        <input type="number" name="details[${detailCount}][debit_amount]" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kredit</label>
                        <input type="number" name="details[${detailCount}][credit_amount]" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <input type="text" name="details[${detailCount}][description]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out" onclick="removeDetail(this)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                `;
                detailCount++;
                return row;
            }

            window.removeDetail = function(button) {
                const row = button.closest('.grid');
                row.remove();
            };

            if (addButton) {
                addButton.addEventListener('click', function() {
                    const newRow = createDetailRow();
                    detailsContainer.appendChild(newRow);
                });
            }

            // Validasi total debit dan kredit sebelum submit
            const form = document.getElementById('transaction-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    let totalDebit = 0;
                    let totalCredit = 0;

                    const debitInputs = document.querySelectorAll('input[name*="[debit_amount]"]');
                    const creditInputs = document.querySelectorAll('input[name*="[credit_amount]"]');

                    debitInputs.forEach(input => {
                        if (input.value.trim() === '' || input.value === null) {
                            input.value = 0;
                        }
                        totalDebit += parseFloat(input.value);
                    });

                    creditInputs.forEach(input => {
                        if (input.value.trim() === '' || input.value === null) {
                            input.value = 0;
                        }
                        totalCredit += parseFloat(input.value);
                    });

                    if (totalDebit !== totalCredit) {
                        e.preventDefault();
                        alert('Total debit dan kredit harus sama!');
                    }
                });
            }
        });
    </script>
</x-app-layout>
