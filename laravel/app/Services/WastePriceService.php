<?php

namespace App\Services;

use App\Models\WastePrice;
use App\Models\WasteType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class WastePriceService
{
    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? '';

        return WastePrice::query()
            ->with('wasteType:id,code,name')
            ->when($search, function ($query, $search) {
                $query->whereHas('wasteType', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($filters['waste_type_id'] ?? '', fn ($q, $id) => $q->where('waste_type_id', $id))
            ->when(
                isset($filters['is_active']) && $filters['is_active'] !== '',
                fn ($q) => $q->where('is_active', $filters['is_active'])
            )
            ->orderBy(
                WasteType::select('name')->whereColumn('waste_types.id', 'waste_prices.waste_type_id')
            )
            ->orderBy('effective_date', 'desc')
            ->paginate(10);
    }

    public function findById(string $id): WastePrice
    {
        return WastePrice::with('wasteType.wasteCategory:id,name')->findOrFail($id);
    }

    public function store(array $data): WastePrice
    {
        return DB::transaction(function () use ($data) {
            $isActive = $data['is_active'] ?? true;

            if ($isActive) {
                $this->deactivateOtherPrices($data['waste_type_id']);
            }

            return WastePrice::create($data);
        });
    }

    public function update(string $id, array $data): WastePrice
    {
        return DB::transaction(function () use ($id, $data) {
            $price = $this->findById($id);

            if (isset($data['is_active'])) {
                if ($data['is_active']) {
                    $this->deactivateOtherPrices($price->waste_type_id, $id);
                }
                $price->is_active = $data['is_active'];
            }

            if (isset($data['effective_date'])) {
                $price->effective_date = $data['effective_date'];
            }

            $price->save();

            return $price->fresh()->load('wasteType');
        });
    }

    public function delete(string $id): void
    {
        $price = $this->findById($id);
        $price->delete();
    }

    public function getActivePrice(string $wasteTypeId): ?WastePrice
    {
        return WastePrice::where('waste_type_id', $wasteTypeId)
            ->where('is_active', true)
            ->latest('effective_date')
            ->first();
    }

    private function deactivateOtherPrices(string $wasteTypeId, ?string $excludeId = null): void
    {
        WastePrice::query()
            ->where('waste_type_id', $wasteTypeId)
            ->where('is_active', true)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->update(['is_active' => false]);
    }
}
