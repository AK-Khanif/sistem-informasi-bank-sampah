<?php

namespace App\Services;

use App\Models\WasteCategory;
use Illuminate\Pagination\LengthAwarePaginator;

class WasteCategoryService
{
    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? '';

        return WasteCategory::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function findById(string $id): WasteCategory
    {
        return WasteCategory::findOrFail($id);
    }

    public function store(array $data): WasteCategory
    {
        return WasteCategory::create($data);
    }

    public function update(string $id, array $data): WasteCategory
    {
        $category = $this->findById($id);
        $category->update($data);

        return $category->fresh();
    }

    public function delete(string $id): void
    {
        $category = $this->findById($id);
        $category->delete();
    }
}
