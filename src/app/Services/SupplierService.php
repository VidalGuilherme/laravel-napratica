<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SupplierService
{

    /**
     * Store a newly created resource in storage.
     */
    public function store($validated) : Supplier
    {
        $item = DB::transaction(function () use ($validated) {

            $item = new Supplier();
            $item->fill($validated);
            $item->save();

            return $item;
        });
        
        return $item;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($validated, Supplier $item) : Supplier
    {
        $item = DB::transaction(function () use ($validated, $item) {            

            $item->update(Arr::except($validated, []));

            return $item;
        });

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $item)
    {
        DB::transaction(function () use ($item) {
            $item->delete();
        });
    }

}
