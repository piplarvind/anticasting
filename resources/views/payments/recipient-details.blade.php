@extends('layouts.account_app')

@section('content')
    @include('layouts.payment-dropdown')

    <section class="dashboard-main">
        <div class="container">
            <div class="col-sm-4">
                @include('layouts.account-left-steps-nav')
            </div>
            <div class="col-sm-8">
                <div class="dashboard-right">
                    @if (session('alert-danger'))
                        <div class="alert alert-danger">
                            {{ session('alert-danger') }}
                        </div>
                    @endif
                    @if (session('alert-success'))
                        <div class="alert alert-success">
                            {{ session('alert-success') }}
                        </div>
                    @endif
                    @if (is_object($user_recipient_list) && $user_recipient_list->count() > 1)
                        <div>
                            <a id="recipient-link" href="javascript:void(0)" data-toggle="modal" class="active-btn pull-right"
                                data-target="#recipientModel">Change Recipient</a>
                        </div>
                    @endif
                    <div class="dashboard-heading">
                        @if (session('payment_method') == 'BankAccount')
                            <h4>Recipient Bank Details <span>(Enter your recipient's {{ session('bank_name') }}
                                    account details)</span></h4>
                        @else
                            <h4>Recipient Mobile Details <span>(Enter your recipient's {{ session('payment_method') }}
                                    details)</span></h4>
                        @endif
                    </div>


                    <div class="dashboard-body">
                        <div class="receipient-form">
                            <form action="{{ url('save-recipient-details') }}" method="post">
                                @csrf
                                @if (session('payment_method') == 'BankAccount')
                                    <div class="form-group">
                                        <label>Bank Account No<sup>*</sup></label>
                                        <input type="text" class="form-control" id="bank_account_no"
                                            name="bank_account_no" placeholder="6546 5465 4587 8795"
                                            value="{{ old('bank_account_no') ? old('bank_account_no') : $user_recipient_details->bank_account_no }}">
                                        @error('bank_account_no')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>First Name<sup>*</sup></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        placeholder="John"
                                        value="{{ old('first_name') ? old('first_name') : $user_recipient_details->first_name }}">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Last Name<sup>*</sup></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        placeholder="Smith"
                                        value="{{ old('last_name') ? old('last_name') : $user_recipient_details->last_name }}">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group cun-code">
                                    <label>Phone Number<sup>*</sup></label>
                                    <input type="text" class="form-control" id="phone_no" name="phone_no"
                                        placeholder="(888) 888-8888"
                                        value="{{ old('phone_no') ? old('phone_no') : $user_recipient_details->phone_no }}">
                                    @error('phone_no')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <br>
                                <div class="dashboard-heading">
                                    <h4>Recipient Address</h4>
                                </div>
                                <div class="form-group">
                                    <label>Address<sup>*</sup></label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address') ? old('address') : $user_recipient_details->address }}">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>City<sup>*</sup></label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ old('city') ? old('city') : $user_recipient_details->city }}">
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>State<sup>*</sup></label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        value="{{ old('state') ? old('state') : $user_recipient_details->state }}">
                                    @error('state')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Select Reason For Sending<sup>*</sup></label>
                                    <select class="form-control" name="reason_for_sending" id="reason_for_sending">
                                        <option value="">Select an option</option>
                                        <option value="FAMILY_SUPPORT"
                                            @if ($user_recipient_details->reason_for_sending == 'FAMILY_SUPPORT') selected="selected" @endif>
                                            Family Support
                                        </option>
                                        <option value="EDUCATION"
                                            @if ($user_recipient_details->reason_for_sending == 'EDUCATION') selected="selected" @endif>Education</option>
                                        <option value="TAX_PAYMENT"
                                            @if ($user_recipient_details->reason_for_sending == 'TAX_PAYMENT') selected="selected" @endif>Tax payment
                                        </option>
                                        <option value="OTHER" @if ($user_recipient_details->reason_for_sending == 'OTHER') selected="selected" @endif>
                                            Other</option>
                                    </select>
                                    @error('reason_for_sending')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="dashboard-footer receipient-form-footer clearfix">
                                    <a class="normal-btn" href="{{ route('start-over') }}">Start Over</a>
                                    <a class="normal-btn" href="{{ route('send-receive-details') }}">Back</a>
                                    <input type="submit" class="active-btn" value="Continue to send money">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="all-pop-ups logerin">
        <div class="modal fade" id="recipientModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" onclick="closeRecipient()" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <div class="log-header">
                            <h1>Recipient List</h1>
                        </div>
                        <div class="log-forms inputer">
                            <form method="POST" name="selectRecipientFrm" id="selectRecipientFrm" role="form"
                                action="{{ route('select-recipient') }}" class="form-disable">
                                @csrf
                                @if (is_object($user_recipient_list) && $user_recipient_list->count() > 1)
                                    @foreach ($user_recipient_list as $user_recipient_detail)
                                        <div class="form-group">
                                            <input style="height:20px" type="radio" checked="checked"
                                                id="selecetd_recipient_{{ $user_recipient_detail->id }}"
                                                name="selecetd_recipient" value="{{ $user_recipient_detail->id }}">
                                            <span> {{ $user_recipient_detail->first_name }}
                                                {{ $user_recipient_detail->last_name }} -
                                                +{{ $user_recipient_detail->country_code }}
                                                {{ $user_recipient_detail->phone_no }} </span>
                                        </div>
                                    @endforeach
                                    <input type="submit" value="{{ __('Select Recipient') }}"
                                        data-submit-value="Please wait..." class="btn btn-primary">
                                @else
                                    <p>You don't have recipient list for selected country. To add recipient <a
                                            href="{{ route('add-recipient') }}"> click here</a></p>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery.ccpicker.css') }}">
    <script src="{{ asset('public/js/jquery.ccpicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#phone_no").CcPicker();
            $("#phone_no").CcPicker("setCountryByPhoneCode", "{{ $country_phone_code }}");
            $("#phone_no").CcPicker('readOnly');
        });

        function closeRecipient() {
            $("#recipientModel").modal('hide');
        }
    </script>
    @if ($user_recipient_list->count() > 1 && session('start_over_selected_recipient') == null)
        <script type="text/javascript">
            $(document).ready(function() {
                $("#recipientModel").modal('show');
            });
        </script>
    @endif
@endsection
