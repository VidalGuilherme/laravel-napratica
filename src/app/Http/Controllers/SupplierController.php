<?php

namespace App\Http\Controllers;

use App\Enums\EmailTypes;
use App\Enums\PhoneTypes;
use App\Enums\Retreats;
use App\Enums\StateIndicators;
use App\Enums\SupplierTypes;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\City;
use App\Models\State;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        $states = State::orderBy('uf', 'ASC')->get();
        $phoneTypes = PhoneTypes::getOptions();
        $emailTypes = EmailTypes::getOptions();

        return Inertia::render('Admin/Suppliers/Create', [
            'supplierTypes' => $supplierTypes,
            'retreats' => $retreats,
            'stateIndicators' => $stateIndicators,
            'states' => $states,
            'emailTypes' => $emailTypes,
            'phoneTypes' => $phoneTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $this->authorize('create', Supplier::class);

        $item = $this->service->store($request->validated());

        return redirect(route('admin.suppliers.show', $item->id))->with('success', 'Fornecedor criado com Sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $this->authorize('view', $supplier);        

        $supplierTypes = SupplierTypes::getOptions();
        $retreats = Retreats::getOptions();
        $stateIndicators = StateIndicators::getOptions();
        $states = State::orderBy('uf', 'ASC')->get();
        $phoneTypes = PhoneTypes::getOptions();
        $emailTypes = EmailTypes::getOptions();

        $supplier->load(['addresses', 'contacts', 'contacts.phones', 'contacts.emails']);
        $cities = City::where('state_id', $supplier->addresses[0]->city->state_id)->get();

        return Inertia::render('Admin/Suppliers/Show', [
            'item' => $supplier,
            'supplierTypes' => $supplierTypes,
            'retreats' => $retreats,
            'stateIndicators' => $stateIndicators,
            'states' => $states,
            'cities' => $cities,
            'emailTypes' => $emailTypes,
            'phoneTypes' => $phoneTypes
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
        $states = State::orderBy('uf', 'ASC')->get();        
        $phoneTypes = PhoneTypes::getOptions();
        $emailTypes = EmailTypes::getOptions();

        $supplier->load(['addresses', 'contacts', 'contacts.phones', 'contacts.emails']);
        $cities = City::where('state_id', $supplier->addresses[0]->city->state_id)->get();

        return Inertia::render('Admin/Suppliers/Edit', [
            'item' => $supplier,
            'supplierTypes' => $supplierTypes,
            'retreats' => $retreats,
            'stateIndicators' => $stateIndicators,
            'states' => $states,
            'cities' => $cities,
            'emailTypes' => $emailTypes,
            'phoneTypes' => $phoneTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $this->authorize('update', $supplier);

        $supplier = $this->service->update($request->validated(), $supplier);

        return redirect(route('admin.suppliers.show', $supplier->id))->with('success', 'Fornecedor atualizado com Sucesso!');
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
        $states = State::orderBy('uf', 'ASC')->get();
        $phoneTypes = PhoneTypes::getOptions();
        $emailTypes = EmailTypes::getOptions();

        $supplier->load(['addresses', 'contacts', 'contacts.phones', 'contacts.emails']);
        $cities = City::where('state_id', $supplier->addresses[0]->city->state_id)->get();

        return Inertia::render('Admin/Suppliers/Delete', [
            'item' => $supplier,
            'supplierTypes' => $supplierTypes,
            'retreats' => $retreats,
            'stateIndicators' => $stateIndicators,
            'states' => $states,
            'cities' => $cities,
            'emailTypes' => $emailTypes,
            'phoneTypes' => $phoneTypes
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $this->authorize('delete', $supplier);
        $this->service->destroy($supplier);

        return redirect(route('admin.suppliers.index'))->with('success', 'Fornecedor removido com Sucesso!');;
    }

    /**
     * Display a listing of the resource.
     */
    public function jsonDatatable(Request $request) : AnonymousResourceCollection
    {
        $this->authorize('viewAny', Supplier::class);
        
        $page = $request->get('start', 1);
        $length = $request->get('length', 100);

        $request->page = $page;

        $items = Supplier::paginate($length)->withQueryString();

        $response = SupplierResource::collection($items);

        return $response;
    }
}
