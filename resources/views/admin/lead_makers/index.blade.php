@extends('layouts.admin')
@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-7">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center pt-2 pb-7">
                    <div class="col-md-6 animated fadeInUp">
                        <h1 class="h1 text-white d-inline-block mb-2"><i class="fa fa fa-suitcase mr-2"></i> {{ trans('global.lead_maker.title') }}</h1>
                    </div>
                    <div class="col-md-6 animated fadeInUp text-md-right">
                        @can('lead_maker_create')
                            <a class="btn btn-sm btn-white mt-2" href="{{ route("admin.lead-makers.create") }}">
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
                                    <input type="text" id="table-search" name="term" class="form-control" {{ request()->input('term') }} placeholder="Search Name, Number...">
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
                                <th scope="col" data-orderable="false">{{ trans('global.lead_maker.fields.lead_maker_id') }}</th>
                                <th scope="col" data-orderable="false">{{ trans('global.lead_maker.fields.name') }}</th>
                                <th scope="col" data-orderable="false">{{ trans('global.lead_maker.fields.joining_date') }}</th>
                                <th scope="col" data-orderable="false">{{ trans('global.lead_maker.fields.mobile_number') }}</th>
                                <th scope="col" class="text-center">{{ trans('global.status') }}</th>
                                <th scope="col" class="text-center" data-orderable="false">{{ trans('global.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($leadMakers as $key => $lead_maker)
                                <tr data-entry-id="{{ $lead_maker->id }}">
                                    <td>
                                        {{ $lead_maker->lead_maker_id }}
                                    </td>
                                    <td>
                                        {{ $lead_maker->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $lead_maker->joining_date ?? '' }}
                                    </td>
                                    <td>
                                        {{ $lead_maker->mobile_number ?? '' }}
                                    </td>
                                    <td class="font-weight-bold text-center">
                                        <span class="py-1 text-uppercase px-2 rounded small {{ $lead_maker->status == 1 ? 'bg-success':'bg-danger' }} text-white">{{ $lead_maker->status_text ?? '' }}</span>
                                    </td>
                                    <td class="actions text-center">
                                        <a href="{{ route('admin.lead-makers.tree-view', $lead_maker->id) }}" class="edit"><i class="fa fa-users"></i></a>
                                        {{--<a href="view-channel" class="edit"><i class="fa fa-eye"></i></a>
                                        <a class="edit" data-toggle="modal" data-target="#edit-form"><i class="fa fa-pen"></i></a>
                                        <a class="delete" data-toggle="modal" data-target="#delete-form"><i class="fa fa-trash-alt"></i></a>--}}
                                        @can('lead_maker_show')
                                            <a data-toggle="modal" data-target="#view-lead-maker" class="edit edit-view" data-json="{{ $lead_maker->with('user')->first() }}"><i class="fa fa-eye"></i></a>
                                        @endcan
                                        @can('lead_maker_edit')
                                            <a class="edit" href="{{ route('admin.lead-makers.edit', $lead_maker->id) }}"><i class="fa fa-pen"></i></a>
                                        @endcan
                                        @can('lead_maker_delete')
                                            <a class="delete" data-toggle="modal" data-id="{{ $lead_maker->id }}"><i class="fa fa-trash-alt"></i></a>
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

        <div class="modal fade modal-form" id="view-lead-maker" tabindex="-1" role="dialog">
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
                                    <h3>Lead Maker Details</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label">Lead Maker ID <span class="small">(Automatically generated)</span></label>
                                        <input type="text" id="edit-view-lead-maker-id" readonly class="form-control bg-white" value="LS_CH_02">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="form-control-label">Lead Generate Link <span class="small">(Automatically generated)</span></label>
                                        <input type="text" id="edit-view-lead-generate-link" readonly class="form-control bg-white" value="LS_CH_02">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label">Name</label>
                                        <input type="text" id="edit-view-name" class="form-control" placeholder="Full Name" value="Senthil Balaji">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label">Mobile Number</label>
                                        <input type="text" id="edit-view-mobile-number" class="form-control" placeholder="Mobile Number" value="+91 9876543210">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label">Email Address</label>
                                        <input type="text" id="edit-view-email" class="form-control" placeholder="Email Address" value="test@gmail.com">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="form-control-label">Address</label>
                                        <input type="text" id="edit-view-address" class="form-control" placeholder="Address">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label">City</label>
                                        <input type="text" id="edit-view-city" class="form-control" placeholder="City">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label">PIN Code</label>
                                        <input type="text" id="edit-view-pin-code" class="form-control" placeholder="PIN Code">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label">Join Date</label>
                                        <input type="text" id="edit-view-joining-date" class="form-control" readonly value="15-09-2024">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label">Channel Status</label>
                                        <select class="form-control" id="edit-view-status" placeholder="Status">
                                            <option>Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">In Active</option>
                                        </select>
                                    </div>
                                </div>
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
                            <form id="delete-form-form" method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-white my-3">Yes, Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
{{--@can('channel_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.lead-makers.create") }}">
                {{ trans('global.add') }} {{ trans('global.lead_maker.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.lead_maker.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.lead_maker.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.lead_maker.fields.email') }}
                        </th>
                        <th>
                            {{ trans('global.lead_maker.fields.email_verified_at') }}
                        </th>
                        <th>
                            {{ trans('global.lead_maker.fields.roles') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leadMakers as $key => $lead_maker)
                        <tr data-entry-id="{{ $lead_maker->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $lead_maker->name ?? '' }}
                            </td>
                            <td>
                                {{ $lead_maker->email ?? '' }}
                            </td>
                            <td>
                                {{ $lead_maker->email_verified_at ?? '' }}
                            </td>
                            <td>
                                @foreach($lead_maker->roles as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('channel_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.lead-makers.show', $lead_maker->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('channel_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.lead-makers.edit', $lead_maker->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('channel_delete')
                                    <form action="{{ route('admin.lead-makers.destroy', $lead_maker->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>--}}
@endsection
@section('scripts')
@parent
<script>
    $(function () {
        $('.edit-view').click(function () {
            var data = $(this).data('json');
            $('#edit-view-name').val(data.name);
            $('#edit-view-lead-maker-id').val(data.lead_maker_id);
            $('#edit-view-lead-generate-link').val(data.lead_generation_link);
            $('#edit-view-admin-name').val(data.name);
            $('#edit-view-mobile-number').val(data.mobile_number);
            $('#edit-view-email').val(data.user.email);
            $('#edit-view-address').val(data.address);
            $('#edit-view-city').val(data.city);
            $('#edit-view-pin-code').val(data.pin_code);
            $('#edit-view-joining-date').val(data.joining_date);
            $('#edit-view-status').val(data.status);
        })
        $('.delete').on('click', function (e) {
            $('#delete-form').modal('show');
            var id = $(this).data('id');
            let url = "{{ route('admin.lead-makers.destroy', '') }}";
            $('#delete-form form').attr('action', url + '/' + id);
        });
  /*let deleteButtonTrans = ' trans('global.datatables.delete') '
  let deleteButton = {
    text: deleteButtonTrans,
    url: " 'admin.lead-makers.massDestroy'",
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
@can('lead_maker_delete')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })*/
})

</script>
@endsection
