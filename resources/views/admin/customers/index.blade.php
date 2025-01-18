@extends('layouts.admin')
@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-7">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center pt-2 pb-7">
                    <div class="col-md-6 animated fadeInUp">
                        <h1 class="h1 text-white d-inline-block mb-2"><i class="fa fa fa-users mr-2"></i> {{ trans('global.customer.title') }}</h1>
                    </div>
                    <div class="col-md-6 animated fadeInUp text-md-right">
                        @can('customer_create')
                        <a class="btn btn-sm btn-white mt-2" href="{{ route("admin.customers.create") }}">
                            <i class="fa fa-plus mr-2"></i>{{ trans('global.add') }} {{ trans('global.new') }}
                        </a>
                        {{--<a class="btn btn-sm btn-white mt-2" data-toggle="modal" data-target="#add-form"><i class="fa fa-plus mr-2"></i>Add New</a>--}}
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--9">
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
                        <form action="" method="GET">
                        <div class="row align-items-center">
                                <div class="col-md-5 mb-3 mb-md-0">
                                <input type="text" id="table-search" name="term" class="form-control" value="{{ request()->input('term') }}" placeholder="Search Name, Number...">
                            </div>
                                <div class="col-md-3">
                                <select class="form-control" name="status">
                                    <option value="">All Status</option>
                                    <option value="1" {{ (isset(request()->status) && request()->status == 1)?'selected="selected"':'' }}>Active</option>
                                    <option value="0" {{ (isset(request()->status) && request()->status == 0)?'selected="selected"':'' }}>InActive</option>
                                </select>
                            </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-sm btn-white mt-2">Search</button>
                                </div>
                        </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="datatable table align-items-center table-flush">
                            <thead>
                            <tr>
                                <th scope="col" data-orderable="false">{{ trans('global.customer.fields.name') }}</th>
                                <th scope="col" data-orderable="false">{{ trans('global.customer.fields.email') }}</th>
                                <th scope="col" data-orderable="false">{{ trans('global.customer.fields.mobile_number') }}</th>
                                <th scope="col" class="text-center">{{ trans('global.registered') }}</th>
                                <th scope="col">{{ trans('global.rewards') }}</th>
                                <!-- <th scope="col" class="text-center">Loan Status</th> -->
                                <th scope="col" class="text-center" data-orderable="false">{{ trans('global.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $key => $customer)
                                <tr data-entry-id="{{ $customer->id }}">
                                    <td>
                                        {{ $customer->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $customer->email ?? '' }}
                                    </td>
                                    <td>
                                        {{ $customer->mobile_number ?? '' }}
                                    </td>
                                    <td class="font-weight-bold text-center">
                                        <span class="py-1 text-uppercase px-2 rounded bg-purple text-white">{{ $customer->registered ?? '' }}</span>
                                    </td>
                                    <td class="font-weight-bold text-center">
                                        <span class="py-1 text-uppercase px-2 rounded bg-yellow text-black">{{ $customer->rewards ?? '' }}</span>
                                    </td>
                                    <!-- <td class="font-weight-bold text-center">
                                    <span class="py-1 text-uppercase px-2 rounded small bg-success text-white">Approved</span>
                                </td> -->
                                    <td class="actions text-center">
                                        {{--<a href="view-customer" class="edit"><i class="fa fa-eye"></i></a>
                                        <a class="edit" data-toggle="modal" data-target="#edit-form"><i class="fa fa-pen"></i></a>
                                        <a class="delete" data-toggle="modal" data-target="#delete-form"><i class="fa fa-trash-alt"></i></a>--}}
                                        @can('customer_show')
                                            <a href="{{ route('admin.customers.show', $customer->id) }}"class="edit"><i class="fa fa-eye"></i></a>
                                            @if(!\App\User::where('email', $customer->email)->exists())
                                                <a href="{{ route('admin.lead-makers.convert', ['id' => $customer->id]) }}" title="Convert to Lead Maker"><i class="fa fa-user-tie"></i></a>
                                            @endif
                                        @endcan
                                        @can('customer_edit')
                                            <a class="edit" href="{{ route('admin.customers.edit', $customer->id) }}"><i class="fa fa-pen"></i></a>
                                        @endcan
                                        @can('customer_delete')
                                            <a class="delete" data-id="{{ $customer->id }}"><i class="fa fa-trash-alt"></i></a>
                                        @endcan
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-form" id="add-form" tabindex="-1" role="dialog">
            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card bg-form border-0 mb-0">
                            <div class="text-right">
                                <button type="button" class="close mt-3 mr-3" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="card-body px-lg-5 py-lg-2">
                                <div class="text-muted mb-4">
                                    <h3>Add New Customer</h3>
                                </div>
                                <form role="form">
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Customer Name" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Email Address" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Mobile Number" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Password" type="password" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            </div>
                                            <select class="form-control">
                                                <option value="0">Status</option>
                                                <option value="0">Approved</option>
                                                <option value="0">Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group-alternative">
                                            <textarea class="form-control" placeholder="Customer Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <div class="input-group-alternative">
                                                <input type="text" class="form-control" placeholder="City" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <div class="input-group-alternative">
                                                <input type="text" class="form-control" placeholder="Pin Code" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pb-lg-3">
                                        <button type="button" class="btn btn-primary btn-block my-3">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-form" id="edit-form" tabindex="-1" role="dialog">
            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card bg-form border-0 mb-0">
                            <div class="text-right">
                                <button type="button" class="close mt-3 mr-3" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="card-body px-lg-5 py-lg-2">
                                <div class="text-muted mb-4">
                                    <h3>Edit Customer</h3>
                                </div>
                                <form role="form">
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Customer Name" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Email Address" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Mobile Number" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Password" type="password" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            </div>
                                            <select class="form-control">
                                                <option value="0">Status</option>
                                                <option value="0">Approved</option>
                                                <option value="0">Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group-alternative">
                                            <textarea class="form-control" placeholder="Customer Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <div class="input-group-alternative">
                                                <input type="text" class="form-control" placeholder="City" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <div class="input-group-alternative">
                                                <input type="text" class="form-control" placeholder="Pin Code" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pb-lg-3">
                                        <button type="button" class="btn btn-primary btn-block my-3">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-form" id="delete-form" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-danger modal- modal-dialog-centered modal-sm" role="document">
                <div class="modal-content bg-gradient-danger">
                    <div class="modal-body p-0 text-center">
                        <div class="text-right">
                            <button type="button" class="close mt-3 mr-3" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="mt-5 mb-4 pl-4 pr-4 text-white">
                            <i class="fa fa-exclamation-triangle" style="font-size: 35px"></i>
                            <h3 class="heading mt-3">Are you sure?</h3>
                            <p>Do you really want to delete this customer? <br>This process cannot be undone.</p>
                            <form class="delete-popup" action="" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-white my-3">{{ trans('global.yes') }}, {{ trans('global.delete') }}</button>
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
        $('.delete').on('click', function (e) {
            $('#delete-form').modal('show');
            var id = $(this).data('id');
            let url = "{{ route('admin.customers.destroy', '') }}";
            $('.delete-popup').attr('action', url + '/' + id);
        });
        /*let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.customers.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('customer_delete')
        dtButtons.push(deleteButton)
@endcan

        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
      })*/
    });
</script>
@endsection
