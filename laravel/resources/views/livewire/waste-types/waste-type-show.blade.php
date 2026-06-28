<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Detail Jenis Sampah</h2>
                    <div class="flex gap-2">
                        @can('update', $wasteType)
                            <a href="{{ route('waste-types.edit', $wasteType) }}" wire:navigate
                               class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Edit
                            </a>
                        @endcan
                        <a href="{{ route('waste-types.index') }}" wire:navigate
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Kode</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wasteType->code }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <p class="mt-1 text-sm">
                            @if ($wasteType->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Nama Jenis Sampah</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wasteType->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Kategori</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wasteType->wasteCategory?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Satuan</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wasteType->unit }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <h3 class="text-sm font-medium text-gray-500">Deskripsi</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wasteType->description ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Tanggal Dibuat</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wasteType->created_at->format('d-m-Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Terakhir Diperbarui</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wasteType->updated_at->format('d-m-Y') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
