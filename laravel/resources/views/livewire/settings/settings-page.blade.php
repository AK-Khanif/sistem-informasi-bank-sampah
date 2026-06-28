<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                @if (session('message'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit="save">
                    <div class="space-y-8">

                        {{-- Profil Bank Sampah --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Profil Bank Sampah</h3>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="rw_name" class="block text-sm font-medium text-gray-700">Nama RW</label>
                                    <input type="text" id="rw_name" wire:model="rw_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('rw_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="bank_sampah_name" class="block text-sm font-medium text-gray-700">Nama Bank Sampah</label>
                                    <input type="text" id="bank_sampah_name" wire:model="bank_sampah_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('bank_sampah_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="rw_address" class="block text-sm font-medium text-gray-700">Alamat RW</label>
                                    <textarea id="rw_address" wire:model="rw_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    @error('rw_address') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="rw_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                    <input type="text" id="rw_phone" wire:model="rw_phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('rw_phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Prefiks Kode --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Prefiks Kode</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label for="customer_prefix" class="block text-sm font-medium text-gray-700">Kode Nasabah</label>
                                    <input type="text" id="customer_prefix" wire:model="customer_prefix" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('customer_prefix') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="deposit_prefix" class="block text-sm font-medium text-gray-700">Transaksi Setor</label>
                                    <input type="text" id="deposit_prefix" wire:model="deposit_prefix" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('deposit_prefix') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="sale_prefix" class="block text-sm font-medium text-gray-700">Transaksi Jual</label>
                                    <input type="text" id="sale_prefix" wire:model="sale_prefix" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('sale_prefix') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Backup --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Backup</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" id="backup_enabled" wire:model="backup_enabled" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <label for="backup_enabled" class="text-sm font-medium text-gray-700">Backup Otomatis</label>
                                </div>
                                <div>
                                    <label for="backup_retention_days" class="block text-sm font-medium text-gray-700">Masa Simpan Backup (hari)</label>
                                    <input type="number" id="backup_retention_days" wire:model="backup_retention_days" min="1" max="365" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('backup_retention_days') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" wire:loading.attr="disabled">
                                Simpan
                            </button>
                            <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
