<?php

namespace App\Http\Controllers\Admin;

use App\LeadMaker;
use App\PaymentTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payments = PaymentTransfer::orderBy('id', 'desc')->get();
        $leadMaker = auth()->user()->leadMaker;
        if($leadMaker || $request->has('search')) {
            $leadMaker = LeadMaker::where('lead_maker_id', $request->search)->first();
            $leadMaker = $leadMaker ?? auth()->user()->leadMaker;
            $payments = PaymentTransfer::where('lead_maker_id', $leadMaker->id ?? null)->orderBy('id', 'desc')->get();
        }
        return view('admin.lead_makers.payment_transfer', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leadMaker = LeadMaker::where('lead_maker_id', $request->lead_maker_id)->first();
        if(is_null($leadMaker)) {
            return redirect()->back()->with('error', 'Lead Maker Not Found!');
        }
        $data = [
            'lead_maker_id' => $leadMaker->id,
            'amount' => $request->amount
        ];
        PaymentTransfer::create($data);

        return redirect()->back()->with('success', 'Payment Transfer Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentTransfer  $paymentTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentTransfer $paymentTransfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentTransfer  $paymentTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentTransfer $paymentTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentTransfer  $paymentTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentTransfer $paymentTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentTransfer  $paymentTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentTransfer $paymentTransfer)
    {
        //
    }
}
