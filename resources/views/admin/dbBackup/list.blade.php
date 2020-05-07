@extends('layouts.dashboard.app')

@section('pageTitle','إدارة النسخ الاحتياطية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}">

@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة النسخ الاحتياطية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/dbBackups')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        ادارة النسخ الاحتياطية
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6  col-md-6 col-sm-12">
                        <div class="form-group row">
                            <a id="link" class='btn btn-info' onclick="clickAndDisable(this);" href='\admin\back_up'>تصدير نسخه احتياطية
                                <i id="wating" style="display: none" class="fas fa-circle-notch fa-spin"></i>
                            </a>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End Row -->
                <!-- Start Table  -->
                <table class="table table-bordered table-hover" id="table">
                    <thead>
                    <tr class="text-center">
                        <th>الملف</th>
                        <th>إعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $path = public_path('back_up/Laravel');
                     if (!file_exists($path)) {
                            File::makeDirectory($path, $mode = 0777, true, true);
                        }
                    $files = File::files($path);
                    ?>
                    @foreach($files as $file)
                        <tr class="text-center">
                            <td>
                                <a href="{{"/admin/download/".$file->getRelativePathname()}}">{{$file->getRelativePathname()}}</a>
                            </td>
                            <td>
                                <div class="dropdown dropdown-inline">
                                    <button type="button"
                                            class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="la la-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a class="dropdown-item Confirm" href="{{"/admin/delete/".$file->getRelativePathname()}}"><i class="fa fa-trash"></i>حذف</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                <!-- End Table  -->

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
    <script src="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        function clickAndDisable(link) {
            // disable subsequent clicks
            $('#wating').show();
            link.onclick = function(event) {
                event.preventDefault();
            }
        }
        $(document).ready(function () {
           /* $('#link').click(function () {
                $(this).attr('disabled', 'disabled');
                $('#wating').show();
                link.onclick = function(event) {
                    event.preventDefault();
                }
            });*/
            function clickAndDisable(link) {
                // disable subsequent clicks
                $('#wating').show();
                link.onclick = function(event) {
                    event.preventDefault();
                }
            }
        });
    </script>
@endsection
