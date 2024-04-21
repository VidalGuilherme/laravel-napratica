<?php

namespace App\Services;

use App\Models\Address;
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
            $item->fill(Arr::except($validated, ['addresses']));
            $item->save();

            $addresses = [];
            foreach($validated['addresses']  as $address){
                $zipcode = preg_replace('/[^0-9]/', '', $address['zipcode']);                
                $addresses[] = array_merge($address, [
                    'supplier_id' => $item->id,
                    'zipcode' => $zipcode
                ]);
            }

            Address::upsert($addresses, uniqueBy: ['id']);

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

            $item->update($validated);

            $addresses = [];
            foreach($validated['addresses']  as $address){
                $zipcode = preg_replace('/[^0-9]/', '', $address['zipcode']);                
                $addresses[] = array_merge($address, [
                    'supplier_id' => $item->id,
                    'zipcode' => $zipcode
                ]);
            }

            Address::upsert($addresses, uniqueBy: ['id']);

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
            $item->addresses()->delete();
            $item->delete();
        });
    }

}
