@auth
    @extends('layouts.admin')
    <h1>hello from admin</h1>
@endauth
@guest
    @extends('layouts.client')
    <h1>hello from client</h1>
@endguest
@section('content')
<form action="" method="post">
    @csrf
    <!-- Re-Print Voucher -->
    <section id="reprint" class="d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="reprint__block">
                        <h1 class="d-flex justify-content-center reprint__block--title">Reprint Daily Discount Voucher</h1>
                        <h5 class="d-flex justify-content-center mb-5 reprint__block--subtitle">Enter Discount # or email address to resend Daily Discount Vouchers</h5>
                        <div class="w-75 m-auto reprint__block--form">
                            <div class="form-group row">
                                <label for="discount" class="col-sm-3 col-form-label">Discount #</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="discount" name="discount" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="email" name="email" value="">
                                </div>
                            </div>
                            <div class="text-center mt-5 reprint__block--form__submit-button">
                                <input class="btn btn-success w-25 text-white reprint__block--form__submit-button--link" type="submit" value="Send">
                            </div>
                        </div>
                        <div class="mt-5 reprint__block--footer">
                            <div class="text-center mt-4 reprint__block--form__back-button">
                                <a class="btn btn-success w-50 text-white reprint__block--form__back-button--link" href="{{ route('main') }}">Return to Home page</a>
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