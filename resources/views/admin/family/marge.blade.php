@extends('layouts.dashboard.app')

@section('pageTitle','دمج الاستمارات')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','الاستمارات والزيارات')
@section('navigation3','دمج استمارة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/families')
@section('navigation3_link','/admin/families/'.$family->id.'/marge')
@section('content')
    @php
        $person = $family->person;
        $wives = $family->wives;
        $members = $family->members;
        $recipient_diseases = $person->diseases->pluck('disease_id')->toArray();
        $family_searcher = $family->searcher->pluck('searcher_id')->toArray();
    @endphp
    <style>
        .btn.btn-primary.col mr-3 {
            color: #eee;
        }

        a.btn-primary:hover {
            color: #FFF;
        }

    </style>
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">

                         دمج لاستمارة
                        <span style="color: red;">
                            {{$person->full_name."/".$person->full_name_tr}}</span>
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form action="/admin/families/{{$family->id}}/marge"
                                              method="post">
                    @csrf
                                            <input type="hidden" name="id" value="{{$family->id}}">
                    <div class="row">

                        <!-- Start col -->
                      <div class="col-lg-12">
                            <div class="form-group">
                                <div style="width: 99%;" id="families_yes">
                                    <label class="col-form-label col-lg-12">تحديد مكفولين لدمجهم مع الأسرة
                                    </label>

                                    <select id='selUser5' name="families_yes[]" style='width: 200px;'
                                            multiple>
                                        <option value='0'>- اختر مكفول -</option>
                                        @if(old('families_yes'))
                                            @foreach(old('families_yes') as $family_id)
                                                <?php $family = \App\Family::find($family_id)?>
                                                @if($family)
                                                    <option value="{{$family_id}}"
                                                            selected>{{$family->code}}{{$family->person?$family->person->full_name."-".$family->person->id_number:""}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <div class="col-12">
                        </div>

                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <div class="form-group row">
                        <button type="submit"
                              class="btn btn-success btn-elevate btn-block ">دمج
                            <span id="wating" class="" style="display: none">&nbsp;&nbsp;
                                <span class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                                </span>
                                <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                        </span>
                        </button>
                    </div>
                </div>
            

                    </div>
                </form>
            </div>
        </div>
        
    </div>
@endsection
@section('select2')
    <script>


        $("#selUser5").select2({
            multiple: true,
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
        $("#selUser6").select2({
            multiple: true,
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
@endsection