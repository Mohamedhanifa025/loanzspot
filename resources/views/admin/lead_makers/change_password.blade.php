@extends('layouts.admin')
@section('content')

    <!-- Header -->
    <div class="header bg-primary pb-7">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center pt-2 pb-7">
                    <div class="col-md-6">
                        <h1 class="h1 text-white d-inline-block mb-2"><i class="fa fa fa-user"></i> Hi, {{ auth()->user()->name }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8">
        <div class="row">
            <div class="col-md-6 offset-3">
                <div class="card animated fadeInUp">
                    <div class="card-header">
                        <h3 class="mb-0">Change Password</h3>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success co-md-12">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route("admin.users.update.password") }}" method="POST" class="row">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12 form-group {{ $errors->has('old_password') ? 'has-error' : '' }}">
                                <label class="form-control-label">Old {{ trans('global.user.fields.password') }}</label>
                                <input type="password" name="old_password" class="form-control" placeholder="Old Password" value="">
                                @if($errors->has('old_password'))
                                    <p class="help-block text-danger mb-0">
                                        {{ $errors->first('old_password') }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-12 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label class="form-control-label">New {{ trans('global.user.fields.password') }}</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" value="">
                                @if($errors->has('password'))
                                    <p class="help-block text-danger mb-0">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-12 form-group {{ $errors->has('retype_password') ? 'has-error' : '' }}">
                                <label class="form-control-label">Confirm New {{ trans('global.user.fields.password') }}</label>
                                <input type="password" name="retype_password" class="form-control" placeholder="Confirm Password" value="">
                                @if($errors->has('retype_password'))
                                    <p class="help-block text-danger mb-0">
                                        {{ $errors->first('retype_password') }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right col-12">
                                <button type="submit" class="btn btn-primary">Update {{ trans('global.user.fields.password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
