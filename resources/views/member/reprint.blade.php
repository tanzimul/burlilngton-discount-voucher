@extends('layouts.master')
@section('content')
<!-- <div id="preloader">
  <div id="loader"></div>
</div> -->
<form action="javascript:void(0)" method="post" id="reprintForm">
    @csrf
    <!-- Re-Print Voucher -->
    <section id="reprint">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="reprint__block">
                        <h1 class="text-center">Reprint Daily Discount Voucher</h1>
                        <h5 class="text-center">Enter Discount # or email address to resend Daily Discount Vouchers</h5>
                        <div class="mx-auto mt-5 reprint__block--form">
                            <div class="form-group row">
                                <label for="discount" class="col-sm-3 col-form-label">Discount #</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="discount" name="discount" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email Address</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" autocomplete="off">
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <input type="hidden" name="date" id="dateused">
                                <div class="d-none" id="reprintUrl">{{ route('reprint.voucher') }}</div>
                                <button class="btn btn-success" type="submit" id="sendButton">Send</button>
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
    </section>
    <!-- /Re-Print Voucher -->
</form>

@endsection