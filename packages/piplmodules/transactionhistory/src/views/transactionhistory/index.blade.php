@php
$pageTitle = 'Transfer History';
$breadcrumbs = [['url' => '', 'name' => $pageTitle]];
$dbTable = '';
if ($transfer_histories->count()) {
    $dbTable = $transfer_histories[0]['table'];
}
$dbTable = ' user_payment_transaction';
@endphp
@section('title')
    {{ $pageTitle }}
@endsection
@extends('layouts.admin-account-app')

@section('content')
    @include('layouts.admin-header')
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>Transfer History</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Transfer History
                        </li>
                    </ol>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if (session('alert-success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                {{ session('alert-success') }}
                                <button type="button" class="close h-100" data-dismiss="alert"
                                    aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        @endif
                        @if (session('alert-danger'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <polygon
                                        points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                    </polygon>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                                {{ session('alert-danger') }}
                                <button type="button" class="close h-100" data-dismiss="alert"
                                    aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        @endif
                        @include('Transactionhistory::transactionhistory.filter')
                        <div class="table-responsive essay-table">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Transaction Id</th>
                                        <th>Delivery Method</th>
                                        <th>Sender Name</th>
                                        <th>Send Amount</th>
                                        <th>Recipient Name</th>
                                        <th>Recipient Amount</th>
                                        <th>Transfer Status</th>
                                        <th>Date</th>
                                        {{-- <th>Reason</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($transfer_histories) && $transfer_histories->count())
                                        @foreach ($transfer_histories as $k => $transfer_history)
                                            <tr class="@if ($k % 2 == 0) even @else odd @endif pointer"
                                                @if ($transfer_history) data-title="{{ json_decode($transfer_history->transaction_response)->payer->service->name }}" @endif>
                                                <td>{{ $transfer_history->id }}</td>
                                                <td><a
                                                        href="{{ route('admin.transactions.history.detail', [$transfer_history->id]) }}">{{ $transfer_history->transaction_id }}</a>
                                                </td>
                                                <td class="user_name_col_{{ $transfer_history->id }}">
                                                    {{ json_decode($transfer_history->transaction_response)->payer->service->name }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->sender->firstname . ' ' . json_decode($transfer_history->transaction_response)->sender->lastname }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->source->amount . ' ' . json_decode($transfer_history->transaction_response)->source->currency }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->beneficiary->firstname . ' ' . json_decode($transfer_history->transaction_response)->beneficiary->lastname }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->destination->amount . ' ' . json_decode($transfer_history->transaction_response)->destination->currency }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->status_message }}
                                                </td>
                                                {{-- <td>{!! str_replace('_', ' ', json_decode($transfer_history->transaction_response)->purpose_of_remittance) !!}
                                                </td> --}}
                                                <td>{{ date('M jS, Y H:i:s A', strtotime($transfer_history->created_at)) }}
                                                </td>
                                                <td style="text-align: center">
                                                    <span class="act-link">
                                                        <a class="btn btn-primary shadow btn-xs sharp mr-1"
                                                            href="{{ route('admin.transactions.history.detail', [$transfer_history->id]) }}"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Edit"><i class="fa fa-eye"></i></a>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No record found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="filter-sel" style="padding: 0 20px;">
                                <div class="row">
                                    <div class="table-footer">
                                        <div class="count"><i class="fa fa-folder-o"></i>
                                            {{ $transfer_histories->total() }}
                                            {{ trans('Core::operations.item') }}</div>
                                        <div class="pagination-area"> {!! $transfer_histories->render() !!} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
