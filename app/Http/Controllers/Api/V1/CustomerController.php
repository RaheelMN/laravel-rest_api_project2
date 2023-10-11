<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Http\Requests\v1\StoreCustomerRequest;
use App\Http\Requests\v1\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\DeleteCustomer;
use App\Http\Resources\v1\CustomerCollection;
use App\Http\Resources\v1\CustomerResource;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Customer::paginate(20);
        // return CustomerResource::collection(Customer::paginate(10));
        return new CustomerCollection(Customer::paginate(10));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        return $customer->update($request->all());
        // return $customer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCustomer $delete,Customer $customer)
    {
        $customer->delete();
        return 'record successfully deleted';
    }
}
