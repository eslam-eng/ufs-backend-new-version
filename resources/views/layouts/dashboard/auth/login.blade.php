@extends('layouts.custom-app')

@section('styles')

@endsection

@section('class')

    <div class="bg-primary">

        @endsection

        @section('content')

            <div class="page-single">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-45 justify-content-center">
                            <div class="card-sigin mt-5 mt-md-0">
                                <!-- Demo content-->
                                <div class="main-card-signin d-md-flex">
                                    <div class="wd-100p"><div class="d-flex mb-4"><a href="{{route('home')}}"><img src="{{asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a></div>
                                        <div class="">
                                            <div class="main-signup-header">
                                                <h2>Welcome back!</h2>
                                                <h6 class="font-weight-semibold mb-4">Please sign in to continue.</h6>
                                                <div class="panel panel-primary">
                                                    <div class="panel-body tabs-menu-body border-0 p-3">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="tab5">
                                                                <form action="{{route('singin')}}" method="post">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label>@lang('app.email_or_phone')</label> <input class="form-control" name="identifier" placeholder="@lang('app.email_or_phone')" type="text">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>@lang('app.password')</label> <input name="password" class="form-control" placeholder="********" type="password">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary btn-block">@lang('app.sign_in')</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="main-signin-footer text-center mt-3">
                                                    <p><a href="{{url('forgot')}}" class="mb-3">Forgot password?</a></p>
                                                </div>
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

        @section('scripts')

            <!-- generate-otp js -->
            <script src="{{asset('assets/js/generate-otp.js')}}"></script>

@endsection
