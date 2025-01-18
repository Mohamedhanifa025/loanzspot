@extends('layouts.admin')
@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-7">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center pt-2 pb-7">
                    <div class="col-md-12 text-center animated fadeInUp">
                        <h1 class="h1 text-white d-inline-block mb-2"><i class="fa fa-building mr-2"></i> Edit Channel</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container mt--9">
        <div class="row">
            <div class="col-md-8 offset-2">
                <div class="card animated fadeInUp">
                    <div class="card-header">
                        <h3 class="mb-0">Edit Channel</h3>
                    </div>
                    <div class="card-body">
                        <form class="row" action="{{ route("admin.channels.update", $channel->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="col-md-6 form-group">
                                <label class="form-control-label">Channel ID <span class="small">(Automatically generated)</span></label>
                                <input type="text" readonly name="channel_id" class="form-control" value="{{ old('channel_id', isset($channel) ? $channel->channel_id : '') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label">Channel Name<span class="text-red">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Channel Name" value="{{ old('name', isset($channel) ? $channel->name : '') }}" required>
                            </div>
                            <div class="col-md-6 form-gro   up">
                                <label class="form-control-label">Full Name<span class="text-red">*</span></label>
                                <input type="text" name="admin_full_name" class="form-control" placeholder="Full Name" value="{{ old('admin_full_name', isset($channel) ? $channel->user->name : '') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label">Mobile Number<span class="text-red">*</span></label>
                                <input type="text" name="mobile_number" class="form-control" placeholder="Mobile Number" value="{{ old('mobile_number', isset($channel) ? $channel->mobile_number : '') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label">Email Address<span class="text-red">*</span></label>
                                <input type="text" name="email" class="form-control" placeholder="Email Address" value="{{ old('email', isset($channel) ? $channel->user->email : '') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label">Password</label>
                                <input type="text" name="password" class="form-control" placeholder="Password" value="">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="form-control-label">Address<span class="text-red">*</span></label>
                                <input type="text" name="address" class="form-control" placeholder="Address" value="{{ old('address', isset($channel) ? $channel->address : '') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label">City<span class="text-red">*</span></label>
                                <input type="text" name="city" class="form-control" placeholder="City" value="{{ old('city', isset($channel) ? $channel->city : '') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label">PIN Code<span class="text-red">*</span></label>
                                <input type="text" name="pin_code" class="form-control" placeholder="PIN Code" value="{{ old('pin_code', isset($channel) ? $channel->pin_code : '') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label">Join Date<span class="text-red">*</span></label>
                                <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date', isset($channel) ? $channel->joining_date : '') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label">Channel Status<span class="text-red">*</span></label>
                                <select class="form-control" name="status" placeholder="Status" required>
                                    <option value="">Select</option>
                                    <option value="1" {{ (in_array(1, old('status', [])) || isset($channel) && $channel->status == 1) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ (in_array(0,  old('status', [])) || isset($channel) && $channel->status == 0) ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="text-right col-12">
                                <button type="submit" class="btn btn-primary">{{ trans('global.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('styles')
    <style>
        .form-group {
            margin-bottom: 0;
        }
    </style>
@endsection
