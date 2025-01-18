@extends('layouts.admin')
@section('content')
    <!-- Header -->
    <?php
        $admin = false;
        if(in_array('Admin' ,auth()->user()->roles()->pluck('title')->toArray())) {
            $admin = true;
        }
    ?>
    <div class="header bg-primary pb-7">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center pt-2 {{ $admin ? 'pb-7' : 'pb-3' }}">
                    <div class="col-md-6 animated fadeInUp">
                        <h1 class="h1 text-white d-inline-block mb-2"><i class="fa fa fa-rupee-sign mr-2"></i> Payment History</h1>
                    </div>
                    @can('lead_maker_access')
                    <div class="col-md-6 animated fadeInUp text-md-right">
                        <a class="btn btn-sm btn-white mt-2" data-toggle="modal" data-target="#view-form"><i class="fa fa-plus mr-2"></i>Payment Transfer</a>
                    </div>
                    @endcan
                </div>
                @if(!$admin)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-stats animated fadeInUp">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-2">Current Rewards</h5>
                                            <span class="h2 font-weight-bold mb-0">12,000</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="fa fa-rupee-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-stats animated fadeInUp">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-2">Total Earned</h5>
                                            <span class="h2 font-weight-bold mb-0">60,000</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="fa fa-rupee-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid {{ $admin ? 'mt--9' : 'mt--7' }}">
        <div class="row">
            @if(session('success'))
                <div class="alert alert-success co-md-12">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="col-xl-12">
                <div class="card animated fadeInUp">
                        <div class="card-header border-0">
                            @can('lead_maker_access')
                                <form action="{{ route('admin.payment-transfer.index') }}" method="GET">
                                    @csrf
                                    <div class="row align-items-center">
                                        <div class="col-md-5 mb-3 mb-md-0">
                                            <input type="text" name="search" id="table-search" class="form-control" placeholder="Search by Lead Maker ID">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-sm btn-primary mt-2">Search</button>
                                        </div>
                                    </div>
                                </form>
                            @endcan
                        </div>
                    <div class="table-responsive">
                        <table class="datatable table align-items-center table-flush">
                            <thead>
                            <tr>
                                <th scope="col" data-orderable="false">Lead Maker ID</th>
                                <th scope="col" data-orderable="false">Name</th>
                                <th scope="col" data-orderable="false">Amount</th>
                                <th scope="col" data-orderable="false">Transfer Date</th>
                                <th scope="col" data-orderable="false">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->leadMaker->lead_maker_id }}</td>
                                        <td>{{ $payment->leadMaker->name }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td>{{ date('d-m-Y', strtotime($payment->created_at)) }}</td>
                                        <td><span class="py-1 text-uppercase px-2 rounded small bg-success text-white">{{ $payment->status == 0 ? 'Transferred' : 'Initiated' }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-form" id="view-form" tabindex="-1" role="dialog">
            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card bg-form border-0 mb-0">
                            <div class="text-right">
                                <button type="button" class="close mt-3 mr-3" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="card-body py-lg-2 mb-2">
                                <div class="text-muted mb-4">
                                    <h3>Payment Transfer</h3>
                                </div>
                                <form action="{{ route('admin.payment-transfer.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="form-control-label">Lead Maker ID</label>
                                            <input name="lead_maker_id" type="text" class="form-control" placeholder="Enter Lead Maker ID">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label class="form-control-label">Amount</label>
                                            <input name="amount" type="text" class="form-control" placeholder="Enter the amount">
                                        </div>
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
    @parent
    <script>
        $(function () {
        })

    </script>
    @endsection
    @section('styles')
        <style type="text/css">
            .window {
                font-weight: bold;
                cursor: pointer;
                border: 1px solid #939393;
                box-shadow: 2px 2px 6px #ccc;
                border-radius: 0.5em;
                /*
                opacity:0.8;
                filter:alpha(opacity=80);
                */
                width: 10em;
                height: auto;
                padding: 0.5em 0em;
                text-align: center;
                z-index: 20;
                position: absolute;
                background-color: #eeeeef;
                color: black;
                font-size: 13px;
                word-wrap: break-word;
            }

            .collapser {
                cursor: pointer;
                border: 1px dotted transparent;
                z-index: 21;
            }

            .errorWindow {
                border: 2px solid red;
            }

            #treemain {
                height: 500px;
                width: 100%;
                position: relative;
                overflow: auto;
            }

            #treemain .window:first-child {
                background: #cedaff;
                border-color: #3055e5;
            }
    </style>
    @endsection
