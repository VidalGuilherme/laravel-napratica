<?php

namespace App\Http\Controllers;

use App\Enums\Retreats;
use App\Enums\StateIndicators;
use App\Enums\SupplierTypes;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class SupplierController extends Controller
{

    public function __construct(
        protected SupplierService $service
    ){
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : InertiaResponse
    {
        $this->authorize('viewAny', Supplier::class);
        
        $items = Supplier::paginate(100);

        return Inertia::render('Admin/Suppliers/Index', [
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Supplier::class);

        $supplierTypes = SupplierTypes::getOptions();
        $retreats = Retreats::getOptions();
        $stateIndicators = StateIndicators::getOptions();

        return Inertia::render('Admin/Suppliers/Create', [
            'supplierTypes' => $supplierTypes,
            'retreats' => $retreats,
            'stateIndicators' => $stateIndicators,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $this->authorize('create', Supplier::class);

        $item = $this->service->store($request->validated());

        return redirect(route('admin.fornecedores.show', $item->id));
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $this->authorize('view', $supplier);        

        return Inertia::render('Admin/Suppliers/Show', [
            'item' => $supplier
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $this->authorize('update', $supplier);

        $supplierTypes = SupplierTypes::getOptions();
        $retreats = Retreats::getOptions();
        $stateIndicators = StateIndicators::getOptions();

        return Inertia::render('Admin/Suppliers/Edit', [
            'supplierTypes' => $supplierTypes,
            'retreats' => $retreats,
            'stateIndicators' => $stateIndicators,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $this->authorize('update', $supplier);

        $supplier = $this->service->update($request->validated(), $supplier);

        return redirect(route('admin.fornecedores.show', $supplier->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Supplier $supplier)
    {
        $this->authorize('delete', $supplier);

        $supplierTypes = SupplierTypes::getOptions();
        $retreats = Retreats::getOptions();
        $stateIndicators = StateIndicators::getOptions();

        return Inertia::render('Admin/Suppliers/Delete', [
            'supplierTypes' => $supplierTypes,
            'retreats' => $retreats,
            'stateIndicators' => $stateIndicators,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $this->authorize('delete', $supplier);
        $this->service->destroy($supplier);

        return redirect(route('admin.fornecedores.index'));
    }
}
