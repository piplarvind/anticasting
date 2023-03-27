@extends('layouts.auth')
@section('content')
    <section id="contact-us" class="contact-us section background-img">
        @if (Session::has('message'))
            <script></script>

            <div id="dialog" title="Error">
                <p>{{ Session::get('message') }}</p>
            </div>
        @elseif (Session::has('error'))
            <div id="dialog" title="Error">
                <p>{{ Session::get('error') }}</p>
            </div>
        @endif
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-5 col-md-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-body">
                            <h3 class="text-center text-danger font-weight-light my-4">Change Password</h3>
                            <form action="{{ route('users.changepassword-post') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="oldPassword">Old Password</label>
                                    <input class="form-control" id="oldPassword" name="oldpassword" type="password"
                                        placeholder="Enter a old password" />
                                    @error('oldpassword')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="NewPassword">New Password</label>
                                    <input class="form-control" id="NewPassword" name="password" type="password"
                                        placeholder="Enter new password" />
                                    @error('password')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="NewPassword">New Confirm Password</label>
                                    <input class="form-control" id="confirmPassword" name="confirm_password" type="password"
                                        placeholder="Enter cofiram password" />
                                    @error('confirm_password')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
        
                                    <button type="submit" class=" form-control btn btn-danger">Change Password</button>
                                </div>
                            </form>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

