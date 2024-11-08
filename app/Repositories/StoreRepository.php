<?php

namespace App\Repositories;

use App\Models\Store;

class StoreRepository
{
    /**
     * Get all stores.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Store::all();
    }

    /**
     * Get a store by its ID.
     *
     * @param  int  $id
     * @return \App\Models\Store|null
     */
    public function getById(int $id)
    {
        return Store::find($id);
    }

    /**
     * Create a new store.
     *
     * @param  array  $data
     * @return \App\Models\Store
     */
    public function create(array $data)
    {
        return Store::create($data);
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
        $store = Store::find($id);

        if ($store) {
            $store->update($data);
            return $store;
        }

        return null;
    }

    /**
     * Delete a store.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id)
    {
        $store = Store::find($id);

        if ($store) {
            return $store->delete();
        }

        return false;
    }
}
