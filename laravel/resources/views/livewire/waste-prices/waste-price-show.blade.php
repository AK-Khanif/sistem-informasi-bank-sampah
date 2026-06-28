<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Detail Harga Sampah</h2>
                    <div class="flex gap-2">
                        @can('update', $wastePrice)
                            <a href="{{ route('waste-prices.edit', $wastePrice) }}" wire:navigate
                               class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Edit
                            </a>
                        @endcan
                        <a href="{{ route('waste-prices.index') }}" wire:navigate
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Jenis Sampah</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $wastePrice->wasteType?->code ?? '-' }} - {{ $wastePrice->wasteType?->name ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Kategori</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wastePrice->wasteType?->wasteCategory?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Harga Beli</h3>
                        <p class="mt-1 text-sm text-gray-900">Rp {{ number_format($wastePrice->buy_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <p class="mt-1 text-sm">
                            @if ($wastePrice->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Tanggal Berlaku</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wastePrice->effective_date->format('d-m-Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Tanggal Dibuat</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wastePrice->created_at->format('d-m-Y H:i') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Terakhir Diperbarui</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $wastePrice->updated_at->format('d-m-Y H:i') }}</p>
                    </div>
                </div>

                @if ($priceHistory->isNotEmpty())
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Riwayat Harga</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Beli</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Berlaku</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($priceHistory as $history)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                Rp {{ number_format($history->buy_price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                {{ $history->effective_date->format('d-m-Y') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                                @if ($history->is_active)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                                <a href="{{ route('waste-prices.show', $history) }}" wire:navigate
                                                   class="text-blue-600 hover:text-blue-900">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
