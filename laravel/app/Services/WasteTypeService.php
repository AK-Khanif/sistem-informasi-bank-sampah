<?php

namespace App\Services;

use App\Models\WasteType;
use Illuminate\Pagination\LengthAwarePaginator;

class WasteTypeService
{
    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? '';

        return WasteType::query()
            ->with('wasteCategory:id,name')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->when($filters['waste_category_id'] ?? '', fn ($q, $id) => $q->where('waste_category_id', $id))
            ->orderBy('code')
            ->paginate(10);
    }

    public function findById(string $id): WasteType
    {
        return WasteType::with('wasteCategory:id,name')->findOrFail($id);
    }

    public function store(array $data): WasteType
    {
        return WasteType::create($data);
    }

    public function update(string $id, array $data): WasteType
    {
        $type = $this->findById($id);
        $type->update($data);

        return $type->fresh()->load('wasteCategory:id,name');
    }

    public function delete(string $id): void
    {
        $type = $this->findById($id);
        $type->delete();
    }
}
