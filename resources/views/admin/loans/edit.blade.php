@extends('layouts.admin')
@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-7">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center pt-2 pb-7">
                    <div class="col-md-6 animated fadeInUp">
                        <h1 class="h1 text-white d-inline-block mb-2"><i class="fa fa fa-users mr-2"></i>
                            {{ trans('global.edit') }} {{ trans('global.loan.title_singular') }}
                        </h1>
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
                        <form action="{{ route("admin.loans.update",  [$loan->id]) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                    <label for="type">{{ trans('global.loan.fields.type') }}*</label>
                                    <select id="loan-type" name="type"
                                            class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}">
                                        <option value="pl" {{ $loan->type == 'pl'?'selected':'' }}>Personal Loan
                                        </option>
                                        <option value="bl" {{ $loan->type == 'bl'?'selected':'' }}>Business Loan
                                        </option>
                                        <option value="hl" {{ $loan->type == 'hl'?'selected':'' }}>Home Loan</option>
                                        <option value="cl" {{ $loan->type == 'cl'?'selected':'' }}>Car Loan</option>
                                        <option value="dl" {{ $loan->type == 'dl'?'selected':'' }}>Doctor Loan</option>
                                        <option value="lap" {{ $loan->type == 'lap'?'selected':'' }}>Loan Against
                                            Property
                                        </option>
                                    </select>
                                    @if($errors->has('type'))
                                        <p class="help-block">
                                            {{ $errors->first('type') }}
                                        </p>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('global.loan.fields.type_helper') }}
                                    </p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">Your Name</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           value="{{ $loan->name }}" name="name" placeholder="Enter your name">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">Your Email</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           value="{{ $loan->email }}" name="email" placeholder="Enter your email">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">Mobile Number</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('mobile_number') ? ' is-invalid' : '' }}"
                                           value="{{ $loan->mobile_number }}" name="mobile_number"
                                           placeholder="Enter your mobile number">
                                    @if ($errors->has('mobile_number'))
                                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('mobile_number') }}</strong>
                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div id="pl" class="loans-div col-md-12 form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="">Company Name</label>
                                        <input type="text" value="{{ $loan->company_name }}"
                                               class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                                               name="company_name" placeholder="Enter your company name">
                                        @if ($errors->has('company_name'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_name') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Take Home Salary</label>
                                        <input type="tel" value="{{ $loan->salary }}" placeholder="50000" maxlength="10"
                                               class="form-control {{ $errors->has('salary') ? ' is-invalid' : '' }}"
                                               name="salary" placeholder="Enter your salary">
                                        @if ($errors->has('salary'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('salary') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="bl" class="loans-div col-md-12 form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="">Type of Company</label>
                                        <select name="company_type" id=""
                                                class="form-control {{ $errors->has('company_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Preparatory" {{ $loan->company_type == 'Preparatory'?'selected="selected"':'' }}>
                                                Preparatory
                                            </option>
                                            <option
                                                value="Partnership" {{ $loan->company_type == 'Partnership'?'selected="selected"':'' }}>
                                                Partnership
                                            </option>
                                            <option
                                                value="Other" {{ $loan->company_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('company_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Type of Business</label>
                                        <select name="business_type" id=""
                                                class="form-control {{ $errors->has('business_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Manufacture"{{ $loan->business_type == 'Manufacture'?'selected="selected"':'' }}>
                                                Manufacture
                                            </option>
                                            <option
                                                value="Traders"{{ $loan->business_type == 'Traders'?'selected="selected"':'' }}>
                                                Traders
                                            </option>
                                            <option
                                                value="Other"{{ $loan->business_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('business_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('business_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="hl" class="loans-div col-md-12 form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="">Income Type</label>
                                        <select name="income_type" id=""
                                                class="form-control {{ $errors->has('income_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Salaried" {{ $loan->income_type == 'Salaried'?'selected="selected"':'' }}>
                                                Salaried
                                            </option>
                                            <option
                                                value="Business" {{ $loan->income_type == 'Business'?'selected="selected"':'' }}>
                                                Business
                                            </option>
                                            <option
                                                value="Other" {{ $loan->income_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('income_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('income_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Type of Company</label>
                                        <select name="company_type" id=""
                                                class="form-control {{ $errors->has('company_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Preparatory" {{ $loan->company_type == 'Preparatory'?'selected="selected"':'' }}>
                                                Preparatory
                                            </option>
                                            <option
                                                value="Partnership" {{ $loan->company_type == 'Partnership'?'selected="selected"':'' }}>
                                                Partnership
                                            </option>
                                            <option
                                                value="Other" {{ $loan->company_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('company_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Type of Business</label>
                                        <select name="business_type" id=""
                                                class="form-control {{ $errors->has('business_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Manufacture"{{ $loan->business_type == 'Manufacture'?'selected="selected"':'' }}>
                                                Manufacture
                                            </option>
                                            <option
                                                value="Traders"{{ $loan->business_type == 'Traders'?'selected="selected"':'' }}>
                                                Traders
                                            </option>
                                            <option
                                                value="Other"{{ $loan->business_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('business_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('business_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="cl" class="loans-div col-md-12 form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="">Income Type</label>
                                        <select name="income_type" id=""
                                                class="form-control {{ $errors->has('income_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Salaried" {{ $loan->income_type == 'Salaried'?'selected="selected"':'' }}>
                                                Salaried
                                            </option>
                                            <option
                                                value="Business" {{ $loan->income_type == 'Business'?'selected="selected"':'' }}>
                                                Business
                                            </option>
                                            <option
                                                value="Other" {{ $loan->income_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('income_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('income_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Type of Company</label>
                                        <select name="company_type" id=""
                                                class="form-control {{ $errors->has('company_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Preparatory" {{ $loan->company_type == 'Preparatory'?'selected="selected"':'' }}>
                                                Preparatory
                                            </option>
                                            <option
                                                value="Partnership" {{ $loan->company_type == 'Partnership'?'selected="selected"':'' }}>
                                                Partnership
                                            </option>
                                            <option
                                                value="Other" {{ $loan->company_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('company_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Type of Business</label>
                                        <select name="business_type" id=""
                                                class="form-control {{ $errors->has('business_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Manufacture"{{ $loan->business_type == 'Manufacture'?'selected="selected"':'' }}>
                                                Manufacture
                                            </option>
                                            <option
                                                value="Traders"{{ $loan->business_type == 'Traders'?'selected="selected"':'' }}>
                                                Traders
                                            </option>
                                            <option
                                                value="Other"{{ $loan->business_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('business_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('business_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="dl" class="loans-div col-md-12 form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="">Employee Type</label>
                                        <select name="employee_type" id=""
                                                class="form-control {{ $errors->has('employee_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Employed"{{ $loan->employee_type == 'Employed'?'selected="selected"':'' }}>
                                                Employed
                                            </option>
                                            <option
                                                value="Self Employed"{{ $loan->employee_type == 'Self Employed'?'selected="selected"':'' }}>
                                                Self Employed
                                            </option>
                                        </select>
                                        @if ($errors->has('employee_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('employee_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="lap" class="loans-div col-md-12 form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="">Income Type</label>
                                        <select name="income_type" id=""
                                                class="form-control {{ $errors->has('income_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Salaried" {{ $loan->income_type == 'Salaried'?'selected="selected"':'' }}>
                                                Salaried
                                            </option>
                                            <option
                                                value="Business" {{ $loan->income_type == 'Business'?'selected="selected"':'' }}>
                                                Business
                                            </option>
                                            <option
                                                value="Other" {{ $loan->income_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('income_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('income_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Type of Company</label>
                                        <select name="company_type" id=""
                                                class="form-control {{ $errors->has('company_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Preparatory" {{ $loan->company_type == 'Preparatory'?'selected="selected"':'' }}>
                                                Preparatory
                                            </option>
                                            <option
                                                value="Partnership" {{ $loan->company_type == 'Partnership'?'selected="selected"':'' }}>
                                                Partnership
                                            </option>
                                            <option
                                                value="Other" {{ $loan->company_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('company_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Type of Business</label>
                                        <select name="business_type" id=""
                                                class="form-control {{ $errors->has('business_type') ? ' is-invalid' : '' }}">
                                            <option
                                                value="Manufacture"{{ $loan->business_type == 'Manufacture'?'selected="selected"':'' }}>
                                                Manufacture
                                            </option>
                                            <option
                                                value="Traders"{{ $loan->business_type == 'Traders'?'selected="selected"':'' }}>
                                                Traders
                                            </option>
                                            <option
                                                value="Other"{{ $loan->business_type == 'Other'?'selected="selected"':'' }}>
                                                Other
                                            </option>
                                        </select>
                                        @if ($errors->has('business_type'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('business_type') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group {{ $errors->has('location') ? 'has-error' : '' }}">
                                    <label for="location">{{ trans('global.loan.fields.location') }}</label>
                                    <input type="text" id="location" name="location" class="form-control"
                                           value="{{ old('location', isset($loan) ? $loan->location : '') }}">
                                    @if($errors->has('location'))
                                        <p class="help-block">
                                            {{ $errors->first('location') }}
                                        </p>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('global.loan.fields.location_helper') }}
                                    </p>
                                </div>
                                <div class="col-md-6 form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                                    <label for="message">{{ trans('global.loan.fields.message') }}</label>
                                    <input type="text" id="message" name="message" class="form-control"
                                           value="{{ old('message', isset($loan) ? $loan->message : '') }}">
                                    @if($errors->has('message'))
                                        <p class="help-block">
                                            {{ $errors->first('message') }}
                                        </p>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('global.loan.fields.message_helper') }}
                                    </p>
                                </div>

                                <div class="col-md-6 form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label for="status">{{ trans('global.loan.fields.status') }}</label>
                                    <select name="status" id="status" class="form-control">
                                        <option
                                            value="0" {{ (isset($loan) && $loan->status == 0)?'selected="selected"':''}}>
                                            Pending
                                        </option>
                                        <option
                                            value="1" {{ (isset($loan) && $loan->status == 1)?'selected="selected"':''}}>
                                            Approved
                                        </option>
                                        <option
                                            value="2" {{ (isset($loan) && $loan->status == 2)?'selected="selected"':''}}>
                                            Rejected
                                        </option>
                                    </select>
                                    @if($errors->has('status'))
                                        <p class="help-block">
                                            {{ $errors->first('status') }}
                                        </p>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('global.loan.fields.status_helper') }}
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
    .form-group {
    margin-bottom: 0;
    }
@endsection
