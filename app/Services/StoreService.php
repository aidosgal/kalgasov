<?php

namespace App\Services;

use App\Models\Store;
use App\Repositories\StoreRepository;

class StoreService
{
    protected $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get all stores.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->storeRepository->getAll();
    }

    /**
     * Get a store by its ID.
     *
     * @param  int  $id
     * @return \App\Models\Store|null
     */
    public function getById(int $id)
    {
        return $this->storeRepository->getById($id);
    }

    /**
     * Create a new store.
     *
     * @param  array  $data
     * @return \App\Models\Store
     */
    public function create(array $data)
    {
        return $this->storeRepository->create($data);
    }

    /**
     * Update an existing store.
     *
     * @param  int  $id
     * @param  array  $data
     * @return \App\Models\Store
     */
    public function update(int $id, array $data)
    {
        return $this->storeRepository->update($id, $data);
    }

    /**
     * Delete a store.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->storeRepository->delete($id);
    }
}
