@extends('layouts.account_app')

@section('content')
    @include('layouts.payment-dropdown')
    <section class="dashboard-main">
        <div class="container">
            <div class="transfer-history-outer">
                <h3>Payment Status</h3>
                <div class="table-responsive">
                    <div class="tab-content">
                        <div class="text-center">
                            @if (session('alert-danger'))
                                <h4>Ops! Something went wrong</h4>
                                <h3>
                                    <div class="alert alert-danger">
                                        {{ session('alert-danger') }}
                                    </div>
                                </h3>
                                <a href="{{ route('send-receive-details') }}">Send Money</a>
                            @endif
                            @if (session('alert-success'))
                                <h4>Congratulations!</h4>
                                <h3>
                                    <div class="alert alert-success">
                                        {{ session('alert-success') }}
                                    </div>
                                </h3>
                                <p><a href="{{ route('transfer-history') }}">View Transfer History</a></p>
                            @endif
                            <img src="{{ asset('public') }}/img/transfer-history-bg.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
