@extends('layouts.account_app')

@section('content')
    <section class="setting-page-sec">
        <div class="container">
            <div class="row">
                @include('layouts.account-left-nav')
                <div class="col-md-8">
                    @if (session('alert-danger'))
                        <div class="alert alert-danger">
                            {{ session('alert-danger') }}
                        </div>
                    @endif
                    @if (session('alert-class'))
                        <div class="alert alert-success">
                            {{ session('alert-class') }}
                        </div>
                    @endif
                    @if (session('alert-success'))
                        <div class="alert alert-success">
                            {{ session('alert-success') }}
                        </div>
                    @endif
                    <div class="profile-info">
                        <h3>Notifications</h3>

                        <form action="{{ route('update-notification') }}" method="post" class="form-disable">
                            @csrf
                            <div class="panel-group" id="accordion">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="checkers">
                                                            <input type="checkbox" name="email_notification" id="box-2" value="1"
                                                            {{ isset($user_preferences->email_notification) && $user_preferences->email_notification == '1' ? 'checked="checked"' : '' }}
                                                             />
                                                            <label for="box-2">&nbsp;&nbsp;&nbsp;&nbsp;Emails</label>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <input type="submit" value="{{ __('Update') }}" data-submit-value="Please wait..."
                                    class="active-btn">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </section>
@endsection
