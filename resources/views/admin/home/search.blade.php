@extends('layouts.dashboard.app')
@section('pageTitle','نتائج البحث')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','نتائج البحث')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/search')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        نتائج البحث عن "{{$q}}"
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form method="get" id="search1" class=" mb-5" >
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i
                                        class="flaticon2-search-1"></i></span></div>
                        <input type="text" class="form-control "
                               placeholder="البحث.." name="q" id="q1" value="{{$q??""}}">
                        <div class="input-group-append"><span class="input-group-text"><i
                                        class="la la-close kt-quick-search__close"></i></span></div>
                    </div>
                </form>
                <!-- Start col -->

                @foreach($results as $result)
                    <div class="row">
                        <a href="{{$result->link}}" class="col-12">
                            <label>{{$result->title}}</label>
                        </a>
                    </div>
                    <div class="row" style="width: 95%">
                        <hr class="col-12" style="border: 1px #ccc solid;">
                    </div>
            @endforeach
            {{$results->links()}}
            <!-- End col -->


                <!-- End Row -->
            </div>
        </div>
        <!--end::Portlet-->

    </div>


@endsection

@section('footerJS')
    <script src="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('new_theme/assets/plugins/general/js/global/integration/plugins/bootstrap-datepicker.init.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('new_theme/assets/plugins/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js')}}"
            type="text/javascript"></script>

    <script src="{{asset('new_theme/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"
            type="text/javascript"></script>
    <script>
        $(document).ready(function () {

            $("#q").on('keypress', function (e) {
                if (e.which == 13) {
                    console.log('dodo elgabas');
                    $('#search').submit();
                }
            });
        });

    </script>
    <script>
       /* $(document).ready(function () {

            $("#q1").keyup(function (event) {
                event.preventDefault();
            });
            $("#q1").keydown(function (event) {
                event.preventDefault();
            });
            $("#q1").on('keypress', function (e) {
                if (e.which == 13) {
                    console.log('dodo elgabas');
                    $('#search1').submit();
                }
            });
        });*/

    </script>
@endsection
