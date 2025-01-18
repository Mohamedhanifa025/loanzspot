<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loanzspot - Apply Loan</title>

    <link rel="icon" href="./assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css">
</head>
<body class="apply-loan">

<header class="site-header">
    <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.svg') }}" class="navbar-brand-img" alt="Logo"></a>
</header>
<!-- Header -->
<div class="header bg-primary pb-7">
    <div class="container-fluid">
        <div class="header-body">
            <div class="align-items-center pt-4 pb-7">
                <h1 class="h1 text-white mb-0 text-center">Apply Loan</h1>
            </div>
        </div>
    </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--9 mb-4">
    <div class="card">
        <div class="card-body">
            @if(\Session('success'))
                <p class="alert alert-success">
                    {{ \Session::get('success') }}
                </p>
            @endif
                @if(\Session::has('error'))
                    <p class="alert alert-danger">
                        {{ \Session::get('error') }}
                    </p>
                @endif

            <form class="form" method="POST" action="{{ route('apply.loan.store') }}">
                @csrf
                <input type="hidden" name="lead_reference_id" value="{{ request()->utm_source ?? '' }}">
                <div class="form-group">
                    <label for="">Loan Type</label>
                    <select id="loan-type" name="type" class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}">
                        <option value="pl" {{ old('type') == 'pl'?'selected':'' }}>Personal Loan</option>
                        <option value="bl" {{ old('type') == 'bl'?'selected':'' }}>Business Loan</option>
                        <option value="hl" {{ old('type') == 'hl'?'selected':'' }}>Home Loan</option>
                        <option value="cl" {{ old('type') == 'cl'?'selected':'' }}>Car Loan</option>
                        <option value="dl" {{ old('type') == 'dl'?'selected':'' }}>Doctor Loan</option>
                        <option value="lap" {{ old('type') == 'lap'?'selected':'' }}>Loan Against Property</option>
                    </select>
                    @if ($errors->has('type'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Your Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="Enter your name">
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Your Email</label>
                    <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Enter your email">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Mobile Number</label>
                    <input type="text" class="form-control {{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" name="mobile_number" placeholder="Enter your mobile number">
                    @if ($errors->has('mobile_number'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('mobile_number') }}</strong>
                        </span>
                    @endif
                </div>
                <div id="pl" class="loans-div">
                    <div class="form-group">
                        <label for="">Company Name</label>
                        <input type="text" class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" placeholder="Enter your company name">
                        @if ($errors->has('company_name'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Take Home Salary</label>
                        <input type="tel" placeholder="50000" maxlength="6" decimals="2" class="form-control {{ $errors->has('salary') ? ' is-invalid' : '' }}" name="salary" placeholder="Enter your salary">
                        @if ($errors->has('salary'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('salary') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div id="bl" class="loans-div">
                    <div class="form-group">
                        <label for="">Type of Company</label>
                        <select name="company_type" id="" class="form-control {{ $errors->has('company_type') ? ' is-invalid' : '' }}">
                            <option value="Preparatory">Preparatory</option>
                            <option value="Partnership">Partnership</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('company_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_type') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Type of Business</label>
                        <select name="business_type" id="" class="form-control {{ $errors->has('business_type') ? ' is-invalid' : '' }}">
                            <option value="Manufacture">Manufacture</option>
                            <option value="Traders">Traders</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('business_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('business_type') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div id="hl" class="loans-div">
                    <div class="form-group">
                        <label for="">Income Type</label>
                        <select name="income_type" id="" class="form-control {{ $errors->has('income_type') ? ' is-invalid' : '' }}">
                            <option value="Salaried">Salaried</option>
                            <option value="Business">Business</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('income_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('income_type') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Type of Company</label>
                        <select name="company_type" id="" class="form-control {{ $errors->has('company_type') ? ' is-invalid' : '' }}">
                            <option value="Preparatory">Preparatory</option>
                            <option value="Partnership">Partnership</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('company_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_type') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Type of Business</label>
                        <select name="business_type" id="" class="form-control {{ $errors->has('business_type') ? ' is-invalid' : '' }}">
                            <option value="Manufacture">Manufacture</option>
                            <option value="Traders">Traders</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('business_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('business_type') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div id="cl" class="loans-div">
                    <div class="form-group">
                        <label for="">Income Type</label>
                        <select name="income_type" id="" class="form-control {{ $errors->has('income_type') ? ' is-invalid' : '' }}">
                            <option value="Salaried">Salaried</option>
                            <option value="Business">Business</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('income_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('income_type') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Type of Company</label>
                        <select name="company_type" id="" class="form-control {{ $errors->has('company_type') ? ' is-invalid' : '' }}">
                            <option value="Preparatory">Preparatory</option>
                            <option value="Partnership">Partnership</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('company_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_type') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Type of Business</label>
                        <select name="business_type" id="" class="form-control {{ $errors->has('business_type') ? ' is-invalid' : '' }}">
                            <option value="Manufacture">Manufacture</option>
                            <option value="Traders">Traders</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('business_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('business_type') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div id="dl" class="loans-div">
                    <div class="form-group">
                        <label for="">Employee Type</label>
                        <select name="employee_type" id="" class="form-control {{ $errors->has('employee_type') ? ' is-invalid' : '' }}">
                            <option value="Employed">Employed</option>
                            <option value="Self Employed">Self Employed</option>
                        </select>
                        @if ($errors->has('employee_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('employee_type') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div id="lap" class="loans-div">
                    <div class="form-group">
                        <label for="">Income Type</label>
                        <select name="income_type" id="" class="form-control {{ $errors->has('income_type') ? ' is-invalid' : '' }}">
                            <option value="Salaried">Salaried</option>
                            <option value="Business">Business</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('income_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('income_type') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Type of Company</label>
                        <select name="company_type" id="" class="form-control {{ $errors->has('company_type') ? ' is-invalid' : '' }}">
                            <option value="Preparatory">Preparatory</option>
                            <option value="Partnership">Partnership</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('company_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_type') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Type of Business</label>
                        <select name="business_type" id="" class="form-control {{ $errors->has('business_type') ? ' is-invalid' : '' }}">
                            <option value="Manufacture">Manufacture</option>
                            <option value="Traders">Traders</option>
                            <option value="Other">Other</option>
                        </select>
                        @if ($errors->has('business_type'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('business_type') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Your Location</label>
                    <input type="text" class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" name="location" placeholder="Enter your location">
                    @if ($errors->has('location'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('location') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Your message</label>
                    <textarea class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" placeholder="Enter your message"></textarea>
                    @if ($errors->has('message'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('message') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer pt-0">
    <div class="row mx-0 align-items-center justify-content-lg-between">
        <div class="col-lg-12">
            <div class="copyright text-center">
                &copy; {{ date('Y') }} Loanzspot All Rights Reserved.
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>

<script>
    $("#loan-type").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".loans-div").not("#" + optionValue).hide();
                $("#" + optionValue).show();
            }
        });
    }).change();
</script>

</body>
</html>
