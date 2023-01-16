@extends('layouts.account_app')

@section('content')
    @include('layouts.payment-dropdown')
    <section class="dashboard-main">
        <div class="container">
            <a href="#" class="">Link Account</a>
        </div>
    </section>
@endsection


<script>
    const handler = Plaid.create({
        token: 'GENERATED_LINK_TOKEN',
        onSuccess: (public_token, metadata) => {},
        onLoad: () => {},
        onExit: (err, metadata) => {},
        onEvent: (eventName, metadata) => {},
        receivedRedirectUri: null,
    });
</script>
