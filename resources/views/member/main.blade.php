@extends('layouts.master')

@section('content')
<form action="{{ route('member.store') }}" method="post" id="memberSignupForm">
    @csrf
    <!-- Package Selection -->
    <section id="package" class="d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 mb-5">
                    @if ($errors->any())
                    <div class="alert alert-danger" id="alertMessage">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(session('success'))
                    <div class="alert alert-success" id="alertMessage">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger" id="alertMessage">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <div class="package__block">
                        <h1 class="d-flex justify-content-center">Burlington Springs Golf and Country Club</h1>
                        <div class="w-75 m-auto">
                            <div class="custom-control custom-radio pt-2">
                                <input type="radio" class="custom-control-input" id="package1" name="package" value="regular" required>
                                <label class="custom-control-label border border-secondary rounded w-100 p-4" for="package1">
                                    Save $5 Weekdays (open til 3PM) <br />
                                    Save $10 Weekends & Holidays (7am to 3pm)
                                </label>
                            </div>
                            <div class="custom-control custom-radio pt-2">
                                <input type="radio" class="custom-control-input" id="package2" name="package" value="senior" required>
                                <label class="custom-control-label border border-secondary rounded w-100 p-4" for="package2">
                                    60 & over Seniors Weekdays Reduced Rate (holidays excluded) <br />
                                    $36.50 + HST Walking <br />
                                    $49.50 + HST Riding
                                </label>
                            </div>

                            @auth
                            <div class="custom-control custom-radio pt-2">
                                <input type="radio" class="custom-control-input" id="package3" name="package" value="flyer" required>
                                <label class="custom-control-label border border-secondary rounded w-100 p-4" for="package3">
                                    Frequent Flyers (pro shop assignment only) <br />
                                    $33.50 Weekdays (open till 3PM) <br />
                                    $42.50 Weekends & Holidays (7am to 3pm)
                                </label>
                            </div>
                            @endauth

                            <div class="text-center mt-4">
                                <a class="btn btn-success w-25 text-white" href="#discount">Go</a>
                            </div>
                        </div>
                        <div class="w-75 package__block--footer">
                            <p>- Valid May 11th to Oct 12th, 2020</p>
                            <p>- Cannot be used with Tournament play or combined with other offers</p>
                            <p>- <strong>To qualify for these discounts each player must provide either a paper Daily Discount Voucher or
                                    a Daily Discount Voucher stored on your phone that contains your Discount# and name.</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Package Selection -->

    <!-- Discount Enrollment -->
    <section id="discount" class="d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="discount__block">
                        <h1 class="d-flex justify-content-center discount__block--title">Daily Discount Program Enrollment</h1>
                        <h5 class="d-flex justify-content-center discount__block--subtitle">Complete to receive instant email with personalized and reprintable Daily Discount Vouchers</h5>
                        <div class="w-75 m-auto discount__block--form">
                            <div class="form-group row">
                                <label for="firstName" class="col-sm-4 col-form-label">First Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lastName" class="col-sm-4 col-form-label">Last Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="lastName" name="last_name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">Email Address</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirmEmail" class="col-sm-4 col-form-label">Re-enter Email Address</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="confirmEmail" name="confirm_email" required>
                                </div>
                            </div>
                            <div class="custom-control custom-checkbox package__block--form__radio">
                                <input type="checkbox" class="custom-control-input package__block--form__radio--input" id="newsletter" name="newsletter" value="news">
                                <label class="col-form-label custom-control-label w-100 p-4 package__block--form__radio--label" for="newsletter">
                                    Please add me to your list so I can receive news, special events info and <br />
                                    promotional offers (required for all discounts)
                                </label>
                            </div>
                            <div class="text-center mt-4 discount__block--form__submit-button">
                                <input class="btn btn-success w-25 text-white discount__block--form__submit-button--link" type="submit" value="Submit">
                            </div>
                        </div>
                        <div class="mt-5 discount__block--footer">
                            <div class="text-center discount__block--form__back-button">
                                <a class="btn btn-success w-50 text-white discount__block--form__back-button--link" href="https://www.burlingtonsprings.com/" target="_blank">Return to Home page</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Discount Enrollment -->
</form>
@endsection