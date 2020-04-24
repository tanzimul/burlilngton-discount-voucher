@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Daily Discount Redeemed</h2>
                </div>

                <div class="card-body">
                    <form action="javascript:void(0)" method="post" id="dailyDiscountRedeemedForm">
                        @csrf
                        <div class="row form-row">
                            <div class="col-md-2">
                                <h4 class="pt-4 mt-2">Input</h4>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="dateused">Date of use</label>
                                        <input type="text" class="form-control" name="date" id="dateused" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="discount">Discount #</label>
                                        <input type="number" class="form-control" name="discount" id="discount" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="phone">Phone</label>
                                        <input type="checkbox" class="form-check-input" name="phone" id="phone">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" class="form-control" name="lastname" id="lastname" required readonly>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <div class="text-center">
                                    <div class="d-none" id="discountUrl">{{ route('staff.redeem.discount') }}</div>
                                    <div class="d-none" id="discountUserSearchUrl">{{ route('staff.user.discount') }}</div>
                                    <button type="submit" id="saveForm" class="btn btn-success">Save</button>
                                </div>
                                <div class="mt-4 alert d-none" id="alert">
                                    <span id="response"></span>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Customer Record Inquiry/Edit</h2>
                </div>

                <div class="card-body">
                    <form action="javascript:void(0)" method="post" id="customerRecordInquiryForm">
                        @csrf
                        <div class="row form-row">
                            <div class="col-md-2">
                                <label for="discount">Discount #</label>
                                <input type="number" class="form-control" name="discount" required>
                            </div>
                            <div class="col-md-2">
                                <label for="type">Type *</label>
                                <input type="text" class="form-control" name="type" id="type">
                            </div>
                            <!-- <div class="col-md-1">

                            </div> -->
                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label class="pt-2">First/Last Name</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="first_name" id="firstName">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="last_name" id="lastName">
                                    </div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="col-md-4">
                                        <label class="pt-2" for="email">Email Address</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="email" class="form-control" name="email" id="emailAddress">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-4">
                            <div class="col">
                                <div class="d-none" id="customerRecordUrl">{{ route('staff.customer.record') }}</div>
                                <input type="hidden" name="member_id" id="memeberId">
                                <button type="submit" id="search" class="btn btn-success">Search</button>
                                <button type="submit" id="delete" class="btn btn-success">Delete</button>
                                <button type="submit" id="save" class="btn btn-success">Save</button>
                                <div class="mt-4 alert d-none" id="alert">
                                    <span id="response"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script></script>
@endsection