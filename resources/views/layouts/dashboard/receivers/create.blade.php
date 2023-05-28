@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('receivers_page_title'),'first_list_item' => trans('app.receivers'),'last_list_item' => trans('app.add_receiver')])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                    <form action="{{route('receivers.store')}}" method="post">
                        @csrf
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.receiver_name')</div>
                                <input class="form-control" name="name" value="{{old('name')}}" placeholder="@lang('app.receiver_name')"
                                       type="text" required>
                                @error('name')
                                    <div id="validationServer03Feedback" class="invalid-feedback"> {{$message}} </div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.receiver_phone')</div>
                                <input class="form-control" value="{{old('phone')}}" name="phone" placeholder="@lang('app.receiver_phone')"
                                       type="text" required>
                                @error('phone')
                                    <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.receiving_company')</div>
                                <input class="form-control" value="{{old('receiving_company')}}" name="receiving_company"
                                       placeholder="@lang('app.receiving_company')" type="text" required>

                                @error('receiving_company')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.reference')</div>
                                <input class="form-control" value="{{old('reference')}}" name="reference" placeholder="@lang('app.reference')"
                                       type="text">

                                @error('reference')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>

                       <div>
                           <livewire:company-with-branch-and-departments company_name="company_id" branch_name="branch_id"/>
                           @error('branch_id')
                           <div class="text-danger"> {{$message}}</div>
                           @enderror
                       </div>

                        <div class="card card-success mt-4">
                            <div class="card-header pb-2"><h5 class="card-title mb-0 pb-0">Address Info</h5></div>
                            <div class="card-body text-success">
                                <div class="row row-sm mb-4">
                                    <div class="col-lg">
                                        <div class="main-content-label mg-b-5">@lang('app.address')</div>
                                        <input class="form-control" name="address" value="{{old('address')}}"  placeholder="@lang('app.address')"
                                               type="text" required>

                                        @error('address')
                                        <div class="text-danger"> {{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg">
                                        <div class="main-content-label mg-b-5">@lang('app.lat')</div>
                                        <input class="form-control" value="{{old('lat')}}" name="lat" placeholder="@lang('app.lat')"
                                               type="text">
                                    </div>
                                    <div class="col-lg">
                                        <div class="main-content-label mg-b-5">@lang('app.lng')</div>
                                        <input class="form-control" value="{{old('lng')}}" name="lng" placeholder="@lang('app.lng')"
                                               type="text">
                                    </div>
                                </div>

                                <div class="row row-sm mb-4">
                                    <div class="col-lg">
                                        <div class="main-content-label mg-b-5">@lang('app.postal_code')</div>
                                        <input class="form-control" value="{{old('postal_code')}}" name="postal_code"
                                               placeholder="@lang('app.postal_code')"
                                               type="text">
                                    </div>

                                    <div class="col-lg">
                                        <div class="main-content-label mg-b-5">@lang('app.map_url')</div>
                                        <input class="form-control" value="{{old('map_url')}}" name="map_url" placeholder="@lang('app.map_url')"
                                               type="text">
                                    </div>
                                </div>

                                <div>
                                    <livewire:locations-drop-down/>
                                    @error('city_id')
                                    <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                    @error('area_id')
                                    <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="card-footer mt-4">
                            <div class="form-group mb-0 mt-3 justify-content-end">
                                <div>
                                    <button type="submit" class="btn btn-success"><i
                                            class="fa fa-save pe-2"></i>@lang('app.save')</button>

                                    <a role="button" href="{{route('receivers.index')}}" class="btn btn-danger"><i
                                            class="fa fa-backward pe-2"></i>@lang('app.back')</a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- End Row -->

@endsection
