@extends('layouts.master')

@section('content')
<form action="" method="post" id="memberSignupForm">
    @csrf
    <!-- Package Selection -->
    <section id="package">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="package__block">
                        <h1 class="text-center">Daily Discount Program Enrollment</h1>
                        <div class="mx-auto package__block--form">
                            <div class="custom-control custom-radio pt-2">
                                <input type="radio" class="custom-control-input" id="package1" name="package" value="regular" required checked>
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

                            <div class="mt-5">
                                <div class="form-group row">
                                    <label for="firstName" class="col-sm-4 col-form-label">First Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="firstName" name="first_name" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lastName" class="col-sm-4 col-form-label">Last Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="lastName" name="last_name" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label">Email Address</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="email" name="email" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="confirmEmail" class="col-sm-4 col-form-label">Re-enter Email Address</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="confirmEmail" name="confirm_email" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="newsletter" name="newsletter" value="news" checked required>
                                    <label class="col-form-label custom-control-label p-3" for="newsletter">
                                        Please add me to your list so I can receive news, special events info and promotional offers (required for all discounts)
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="package__block--footer">
                                            <p>- Valid May 11th to Oct 12th, 2020</p>
                                            <p>- Cannot be used with Tournament play or combined with other offers</p>
                                            <p>- <strong>To qualify for these discounts each player must present their personalized Daily Discount Voucher on their phone or paper.</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-4 mb-4">
                                    <div class="d-none" id="memberSignUpUrl">{{ route('member.store') }}</div>
                                    <button class="btn btn-success" type="submit" id="signUpButton">Submit</button>
                                </div>
                                <div id="message"></div>
                            </div>
                            <div class="mt-4">
                                <div class="text-center">
                                    <a class="btn btn-success" href="https://www.burlingtonsprings.com/" target="_blank">Return to Home page</a>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Package Selection -->
</form>
@endsection