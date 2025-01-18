@extends('layouts.admin')
@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-7">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center pt-2 pb-7">
                    <div class="col-md-6 animated fadeInUp">
                        <h1 class="h1 text-white d-inline-block mb-2"><i class="fa fa fa-users mr-2"></i> {{ trans('global.edit') }} {{ trans('global.customer.title_singular') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card animated fadeInUp">
    <div class="card-body">
        <form action="{{ route("admin.customers.update", [$customer->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
            <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.customer.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($customer) ? $customer->name : '') }}">
                @if($errors->has('name'))
                    <p class="help-block text-red">
                        {{ $errors->first('name') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.name_helper') }}
                </p>
            </div>
            <div class="col-md-6 form-group {{ $errors->has('mobile_number') ? 'has-error' : '' }}">
                <label for="mobile_number">{{ trans('global.customer.fields.mobile_number') }}</label>
                <input type="number" id="mobile_number" name="mobile_number" class="form-control" value="{{ old('name', isset($customer) ? $customer->mobile_number : '') }}">
                @if($errors->has('mobile_number'))
                    <p class="help-block text-red">
                        {{ $errors->first('mobile_number') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.mobile_number_helper') }}
                </p>
            </div>
            <div class="col-md-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('global.customer.fields.email') }}</label>
                <input type="text" id="email" name="email" class="form-control" value="{{ old('email', isset($customer) ? $customer->email : '') }}">
                @if($errors->has('email'))
                    <p class="help-block text-red">
                        {{ $errors->first('email') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.email_helper') }}
                </p>
            </div>
                <div class="col-md-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="address">{{ trans('global.customer.fields.password') }}</label>
                    <input type="password" id="password" name="password" class="form-control"
                           value="">
                    @if($errors->has('password'))
                        <p class="help-block text-red">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                    <p class="helper-block">
                        {{ trans('global.customer.fields.password_helper') }}
                    </p>
                </div>
            <div class="col-md-6 form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{ trans('global.customer.fields.email') }}</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($customer) ? $customer->address : '') }}">
                @if($errors->has('address'))
                    <p class="help-block text-red">
                        {{ $errors->first('address') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.address_helper') }}
                </p>
            </div>
            <div class="col-md-6 form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                <label for="city">{{ trans('global.customer.fields.city') }}</label>
                <input type="text" id="city" name="city" class="form-control" value="{{ old('city', isset($customer) ? $customer->city : '') }}">
                @if($errors->has('city'))
                    <p class="help-block text-red">
                        {{ $errors->first('city') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.city_helper') }}
                </p>
            </div>
            <div class="col-md-6 form-group {{ $errors->has('pincode') ? 'has-error' : '' }}">
                <label for="pincode">{{ trans('global.customer.fields.pincode') }}</label>
                <input type="text" id="pincode" name="pincode" class="form-control" value="{{ old('pincode', isset($customer) ? $customer->pincode : '') }}">
                @if($errors->has('pincode'))
                    <p class="help-block text-red">
                        {{ $errors->first('pincode') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.pincode_helper') }}
                </p>
            </div>
            <div class="col-md-6 form-group {{ $errors->has('referred_by') ? 'has-error' : '' }}">
                <label for="referred_by">{{ trans('global.customer.fields.referred_by') }}</label>
                <select name="referred_by" id="referred_by" class="form-control">
                    <option value="">--select--</option>
                    @foreach($customers as $cust)
                        <option value="{{ $cust->id }}" {{ (isset($customer) && $customer->referred_by == $cust->id)?'selected="selected"':''}}>{{ $cust->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('referred_by'))
                    <p class="help-block text-red">
                        {{ $errors->first('referred_by') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.email_helper') }}
                </p>
            </div>
            <div class="col-md-6 form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status">{{ trans('global.customer.fields.status') }}</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" {{ (isset($customer) && $customer->status == 1)?'selected="selected"':''}}>Active</option>
                    <option value="0" {{ (isset($customer) && $customer->status == 0)?'selected="selected"':''}}>InActive</option>
                </select>
                @if($errors->has('status'))
                    <p class="help-block text-red">
                        {{ $errors->first('status') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.status_helper') }}
                </p>
            </div>
            <div class="col-md-12">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
            </div>
        </form>
    </div>
</div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <style type="text/css">
        .form-group {
            margin-bottom: 0;
        }
    </style>
@endsection
