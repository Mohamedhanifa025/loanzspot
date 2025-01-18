@extends('layouts.admin')
@section('content')
<!-- Header -->
<div class="header bg-primary pb-7">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center pt-2 pb-3">
                <div class="col-md-6 animated fadeInUp">
                    <h1 class="h1 text-white d-inline-block mb-2"><i class="fa fa fa-users mr-2"></i> Treeview</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-stats animated fadeInUp">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-2">Current Rewards</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $currentRewards }}</span>
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
                                    <span class="h2 font-weight-bold mb-0">{{ $totalEarned }}</span>
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
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card animated fadeInUp">
                <div class="card-header border-0">
                    <div id="treemain">
                        <div id="node_0" class="window hidden" data-id="0" data-parent="" data-first-child="{{ $treeMap[$leadMaker->lead_maker_id][0]['id'] ?? '' }}" data-next-sibling="">
                            {{ $leadMaker->lead_maker_id }} <span>{{ $leadMaker->name }}</span>
                        </div>
                        @if(count($treeMap))
                            @foreach($treeMap[$leadMaker->lead_maker_id] as $key => $value)
                                @if(is_numeric($key))
                                    @php $next = $treeMap[$leadMaker->lead_maker_id][$key+1] ?? "" @endphp
                                    <div id="node_{{$value['id']}}" class="window hidden" data-id="{{$value['id']}}" data-parent="0" data-first-child="{{ isset($value['data'][$value['lead_maker_id']]) ? $value['data'][$value['lead_maker_id']][0]['id'] : '' }}" data-next-sibling="{{ $next ? $next['id'] : ''}}">
                                        {{ $value['lead_maker_id'] }} {{ $value['name'] }}
                                    </div>
                                    @if(isset($value['data']) && isset($value['data'][$value['lead_maker_id']]))
                                        @foreach($value['data'][$value['lead_maker_id']] as $fkey => $fvalue)
                                            @if(is_numeric($fkey))
                                                @php $fnext = $value['data'][$value['lead_maker_id']][$fkey+1] ?? "" @endphp
                                                <div id="node_{{$fvalue['id']}}" class="window hidden" data-id="{{$fvalue['id']}}" data-parent="{{$value['id']}}" data-first-child="{{ isset($fvalue['data'][$fvalue['lead_maker_id']]) ? $fvalue['data'][$fvalue['lead_maker_id']][0]['id'] : '' }}" data-next-sibling="{{ $fnext ? $fnext['id'] : ''}}">
                                                    {{ $fvalue['lead_maker_id'] }} {{ $fvalue['name'] }}
                                                </div>

                                                @if(isset($fvalue['data']) && isset($fvalue['data'][$fvalue['lead_maker_id']]))
                                                    @foreach($fvalue['data'][$fvalue['lead_maker_id']] as $jkey => $jvalue)
                                                        @if(is_numeric($jkey))
                                                            @php $jnext = $fvalue['data'][$fvalue['lead_maker_id']][$jkey+1] ?? "" @endphp
                                                            <div id="node_{{$jvalue['id']}}" class="window hidden" data-id="{{$jvalue['id']}}" data-parent="{{$fvalue['id']}}" data-first-child="{{ isset($jvalue['data'][$jvalue['lead_maker_id']]) ? $jvalue['data'][$jvalue['lead_maker_id']][0]['id'] : '' }}" data-next-sibling="{{ $jnext ? $jnext['id'] : ''}}">
                                                                {{ $jvalue['lead_maker_id'] }} {{ $jvalue['name'] }}
                                                            </div>
                                                            @if(isset($jvalue['data']) && isset($jvalue['data'][$jvalue['lead_maker_id']]))
                                                                @foreach($jvalue['data'][$jvalue['lead_maker_id']] as $kkey => $kvalue)
                                                                    @if(is_numeric($kkey))
                                                                        @php $knext = $jvalue['data'][$jvalue['lead_maker_id']][$kkey+1] ?? "" @endphp
                                                                        <div id="node_{{$kvalue['id']}}" class="window hidden" data-id="{{$kvalue['id']}}" data-parent="{{$jvalue['id']}}" data-first-child="" data-next-sibling="{{ $knext ? $knext['id'] : ''}}">
                                                                            {{ $kvalue['lead_maker_id'] }} {{ $kvalue['name'] }}
                                                                        </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        @endif
                                                    @endforeach
                                                @endif


                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                        @endif
<!--                        <div id="node_1" class="window hidden" data-id="1" data-parent="0" data-first-child="4" data-next-sibling="2">
                            LS_CRM_001
                        </div>

                        <div id="node_2" class="window hidden" data-id="2" data-parent="0" data-first-child="66" data-next-sibling="3">
                            LS_CRM_002
                        </div>

                        <div id="node_3" class="window hidden" data-id="3" data-parent="0" data-first-child="" data-next-sibling="">
                            LS_CRM_003
                        </div>

                        <div id="node_4" class="window hidden" data-id="4" data-parent="1" data-first-child="" data-next-sibling="5">
                            Node 1-1
                        </div>

                        <div id="node_5" class="window hidden" data-id="5" data-parent="1" data-first-child="" data-next-sibling="">
                            Node 1-2
                        </div>

                        <div id="node_66" class="window hidden" data-id="66" data-parent="2" data-first-child="" data-next-sibling="7">
                            Node 2-1
                        </div>

                        <div id="node_7" class="window hidden" data-id="7" data-parent="2" data-first-child="" data-next-sibling="8">
                            Node 2-2
                        </div>

                        <div id="node_8" class="window hidden" data-id="8" data-parent="2" data-first-child="" data-next-sibling="9">
                            Node 2-3
                        </div>

                        <div id="node_9" class="window hidden" data-id="9" data-parent="2" data-first-child="" data-next-sibling="">
                            Node 2-4
                        </div>-->

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
