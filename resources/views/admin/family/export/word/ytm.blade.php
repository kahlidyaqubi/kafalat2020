@extends('layouts.dashboard.app')

@section('pageTitle','اتنزيل الاستمارات التركيه')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','الاستمارات والزيارات')
@section('navigation3','تنزيل الاستمارات التركيه')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/families')
@section('navigation3_link','/admin/families')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تنزيل الاستمارات التركيه
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                @foreach($files as $file)
                    @php $fileName = $file->getRelativePathname() @endphp
                    @if (strpos($fileName, '~$') === false)
                        <div class="row">
                            <a href="{{  asset('/word_templates_results/ytm/'.$fileName) }}">{{ $fileName }}</a>
                        </div>
                        <hr>
                    @endif
                @endforeach
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
@endsection
