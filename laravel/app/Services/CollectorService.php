<?php

namespace App\Services;

use App\Models\Collector;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CollectorService
{
    private const CODE_PREFIX = 'PNG';

    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? '';

        return Collector::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('collector_code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('contact_person', 'like', "%{$search}%");
                });
            })
            ->orderBy('collector_code')
            ->paginate(10);
    }

    public function findById(string $id): Collector
    {
        return Collector::findOrFail($id);
    }

    public function store(array $data): Collector
    {
        return DB::transaction(function () use ($data) {
            $data['collector_code'] = $this->generateCollectorCode();

            return Collector::create($data);
        });
    }

    public function update(string $id, array $data): Collector
    {
        $collector = $this->findById($id);
        $collector->update($data);

        return $collector->fresh();
    }

    public function delete(string $id): void
    {
        $collector = $this->findById($id);
        $collector->delete();
    }

    public function generateCollectorCode(): string
    {
        $lastCollector = Collector::withTrashed()
            ->where('collector_code', 'like', self::CODE_PREFIX . '-%')
            ->orderBy('collector_code', 'desc')
            ->lockForUpdate()
            ->first();

        if ($lastCollector) {
            $lastNumber = (int) substr($lastCollector->collector_code, strlen(self::CODE_PREFIX) + 1);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf('%s-%06d', self::CODE_PREFIX, $newNumber);
    }
}
