@extends('layouts.dashboard.app')

@section('pageTitle','إضافة مساعدة موسمية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إضافة مساعدة موسمية')
@section('navigation3','اختيار المستلم')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/season_coupons/')
@section('navigation3_link','/admin/season_coupons/searctoaddcoupon')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        اختيار مستلم
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body"  action="/admin/season_coupons/editorcreat">
            @csrf
            <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">نوع المستلم</label>
                            <div style="width: 95%;">
                                <select  required class="form-control kt-select2 select2-multi"
                                        id="type" name="type" onchange="change_type()">
                                    <option value="" selected>نوع المستلم</option>
                                    <option value="1" @if(old('type') == 1)selected @endif> أسرة</option>
                                    <option value="2" @if(old('type') == 2)selected @endif> جمعية</option>
                                    <option value="3" @if(old('type') == 3)selected @endif> أسرة جديدة</option>
                                    <option value="4" @if(old('type') == 4)selected @endif> جمعية جديدة</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->

                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12" id="type1" style="display: none">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">مكفول</label>
                            <div style="width: 95%;">
                                <select id='selUser7' name="family_id" style='width: 200px;'>
                                    <option value='  '>- اختر -</option>
                                    @if(old('family_id'))
                                        <?php $family = \App\Family::find(old('family_id'))?>
                                        @if($family)
                                            <option value="{{$family_id}}"
                                                    selected>{{$family->code}}{{$family->person?$family->person->full_name."-".$family->person->id_number:""}}</option>
                                        @endif
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12 type2" style="display: none">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">جمعية</label>
                            <div style="width: 95%;">
                                <select class="form-control kt-select2 select2-multi"
                                        name="institution_id">
                                    <option value=" " selected> جمعية</option>
                                    @foreach($institutions as $institution)
                                        <option value="{{$institution->id}}"
                                                @if($institution->id == old('institution_id')) selected @endif>{{$institution->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->

                </div>
                <!-- End Row -->

                <!-- Satrt Button Confirm -->
                    <div class="col-12">
                        <button type="submit"
                                  class="btn btn-success btn-elevate btn-block ">إضافة
                                <span id="wating" class="" style="display: none">&nbsp;&nbsp;
                                    <span class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                    </span>
                                    <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                            </span>
                        </button>
                    </div>
                <!-- End Button Confirm -->
            </form>
        </div>
        <!--end::Portlet-->
    </div>


@endsection
@section('select2')
    <script>


        $("#selUser7").select2({
            ajax: {
                url: "/admin/families/families_ajax",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    console.log(params);
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function (response) {

                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
    </script>
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
        $("[name='expense_date']").datepicker({
            format: 'yyyy-mm',
            minViewMode: 1
        });
    </script>
    <script>
        //type
        function change_type(e) {
           
            if ($("#type").val() == '1') {
                $('#type1').show();
                $('.type2').hide();
                $("[name='family_id']").val("");
                $("[name='institution_id']").val("");
            } else if ($("#type").val() == '2') {
                $('.type2').show();
                $('#type1').hide();
            }else{
                 $('#type1').hide();
               $('.type2').hide();
                $("[name='family_id']").val("");
                $("[name='institution_id']").val("");  
            }
        }
    </script>

        <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection