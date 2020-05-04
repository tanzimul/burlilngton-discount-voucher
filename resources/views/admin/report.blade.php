@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reports</div>
                <form action="{{ route('export') }}" method="post" id="exportReportForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="custom-control custom-radio pt-2">
                                    <input type="radio" class="custom-control-input" id="report1" name="report" value="customer_record" required checked autocomplete="off">
                                    <label class="custom-control-label border rounded w-100 p-4" for="report1">Customer Records</label>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio pt-2">
                                    <input type="radio" class="custom-control-input" id="report2" name="report" value="redemption_transactions" required autocomplete="off">
                                    <label class="custom-control-label border rounded w-100 p-4" for="report2">Redemption Transactions</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row" id="fromTo">
                                    <div class="col">
                                        <label for="fromDate" class="col-form-label">From:</label>
                                        <input type="text" class="form-control" id="fromDate" name="from" autocomplete="off"/>
                                    </div>
                                    <div class="col">
                                        <label for="toDate" class="col-form-label">To:</label>
                                        <input type="text" class="form-control" id="toDate" name="to" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio pt-2">
                                    <input type="radio" class="custom-control-input" id="report3" name="report" value="daily_reconciliation" required autocomplete="off">
                                    <label class="custom-control-label border rounded w-100 p-4" for="report3">Daily Reconciliation</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col">
                                        <label for="dailyDate" class="col-form-label">Date:</label>
                                        <input type="text" class="form-control" id="dailyDate" name="date" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">Export</button>
                        </div>
                        <div class="mt-4">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection