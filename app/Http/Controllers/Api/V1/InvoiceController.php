<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Invoice;
use App\Http\Requests\v1\StoreInvoiceRequest;
use App\Http\Requests\v1\BulkStoreInvoiceRequest;
use App\Http\Requests\v1\UpdateInvoiceRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\DeleteInvoice;
use App\Http\Resources\v1\InvoiceCollection;
use App\Http\Resources\v1\InvoiceResource;
use Illuminate\Support\Arr;
// use Illuminate\Http\Request\v1\bulkStoreInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new InvoiceCollection(Invoice::paginate(5));
    }

    /**
     * Store a newly created resource collection in storage.
     */    
    public function bulkStore(BulkStoreInvoiceRequest $request){
        $bulk = collect($request->all())->map(function($arr,$key){
            return Arr::except($arr,['customerID','billedDate','paidDate']);

        });
        // return $bulk;
        return Invoice::insert($bulk->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
       return new InvoiceResource(Invoice::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        return $invoice->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteInvoice $delete,Invoice $invoice)
    {
        $invoice->delete();
        return response('Invoice deleted',200);
    }
}
