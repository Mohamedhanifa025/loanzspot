@extends('layouts.admin')
@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-7">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center pt-2 pb-7">
                    <div class="col-md-12 text-center animated fadeInUp">
                        <h1 class="h1 text-white d-inline-block mb-2"><i class="fa fa fa-user mr-2"></i> {{ trans('global.edit') }} {{ trans('global.user.my_profile') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="container mt--9">
    <div class="row">
        <div class="col-md-8 offset-2">
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success co-md-12">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route("admin.users.update.profile", [$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.user.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}">
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.user.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('global.user.fields.email') }}*</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}">
                @if($errors->has('email'))
                    <p class="help-block">
                        {{ $errors->first('email') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.user.fields.email_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('mobile_number') ? 'has-error' : '' }}">
                <label for="email">{{ trans('global.user.fields.mobile_number') }}*</label>
                <input type="text" id="mobile_number" name="mobile_number" class="form-control" value="{{ old('mobile_number', isset($user) ? $user->mobile_number : '') }}">
                @if($errors->has('mobile_number'))
                    <p class="help-block">
                        {{ $errors->first('mobile_number') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.user.fields.mobile_number_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{ trans('global.customer.fields.address') }}</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($user) ? $user->address : '') }}">
                @if($errors->has('address'))
                    <p class="help-block">
                        {{ $errors->first('address') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.address_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                <label for="city">{{ trans('global.customer.fields.city') }}</label>
                <input type="text" id="city" name="city" class="form-control" value="{{ old('city', isset($user) ? $user->city : '') }}">
                @if($errors->has('city'))
                    <p class="help-block">
                        {{ $errors->first('city') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.city_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('pincode') ? 'has-error' : '' }}">
                <label for="pincode">{{ trans('global.customer.fields.pincode') }}</label>
                <input type="text" id="pincode" name="pincode" class="form-control" value="{{ old('pincode', isset($user) ? $user->pincode : '') }}">
                @if($errors->has('pincode'))
                    <p class="help-block">
                        {{ $errors->first('pincode') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.customer.fields.pincode_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
</div>
    </div>
</div>
@endsection
