@extends('layouts.dashboard.app')

@section('pageTitle','إدارة الاتصالات')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة الاتصالات')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/calls')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إدارة الاتصالات
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form>
                    <div class="row">
                        <!-- start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12 type3">
                            <div class="form-group">
                                <div style="width: 95%;" id="family_ids">
                                    <label class="col-form-label col-lg-12">المكفول
                                    </label>

                                    <select id='selUser' name="family_ids[]" style='width: 200px;'
                                            multiple>
                                        <option value='0'>- اختر مكفولاً -</option>
                                        @if($family_ids)
                                            @foreach($family_ids as $family_id)
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
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;" id="sponsor_ids">
                                    <label class="col-form-label col-lg-12">الكافل
                                    </label>
                                    <select id='selUser2' name="sponsor_ids[]" style='width: 200px;'
                                            multiple>
                                        <option value='0'>- اختر كافلا -</option>
                                        @if($sponsor_ids)
                                            @foreach($sponsor_ids as $sponsor_id)
                                                <?php $sponsor = \App\Sponsor::find($sponsor_id)?>
                                                @if($sponsor)
                                                    <option value="{{$sponsor_id}}"
                                                            selected>{{$sponsor->code}}-{{$sponsor->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">الحالة</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="status" name="status">
                                        <option value=" " selected> الحالة</option>
                                        <option value="1" @if($status == 1)selected @endif> ناجحة</option>
                                        <option value="0" @if($status === '0')selected @endif>فاشلة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">بحث من خلال سبب الاتصال</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" اكتب سبب الاتصال  " id="reason"
                                           name="reason"
                                           value="{{$reason}}"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Start col -->
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">من الرقم</label>
                                <div style="width: 95%;">
                                    <input class="form-control" type="number" name="from_id" value="{{$from_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">إلى الرقم</label>
                                <div style="width: 95%;">
                                    <input class="form-control" type="number" name="to_id" value="{{$to_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Start col -->
                        <div class="col-lg-2 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ الاتصال من</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="from_date" type="text"
                                           value="{{$from_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-2 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ الاتصال إلى</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="to_date" type="text"
                                           value="{{$to_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">تحديد الأعمدة المعروضة </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="coulmn" name="coulmn[]" multiple="multiple">
                                        <option value="id"
                                                @if(collect($coulmn)->contains('id'))selected @endif>#
                                        </option>
                                        <option value="family"
                                                @if(collect($coulmn)->contains('family'))selected @endif>
                                            المكفول
                                        </option>
                                        <option value="sponsor"
                                                @if(collect($coulmn)->contains('sponsor'))selected @endif>
                                            الكافل
                                        </option>
                                        <option value="reason"
                                                @if(collect($coulmn)->contains('reason'))selected @endif>
                                            سبب الاتصال
                                        </option>
                                        <option value="status"
                                                @if(collect($coulmn)->contains('status'))selected @endif>
                                            الحالة
                                        </option>
                                        <option value="admin"
                                                @if(collect($coulmn)->contains('admin'))selected @endif>
                                            مدخل الاتصال
                                        </option>
                                        <option value="his_date"
                                                @if(collect($coulmn)->contains('his_date'))selected @endif>
                                            تاريخ الاتصال
                                        </option>
                                        <option value="operations"
                                                @if(collect($coulmn)->contains('operations'))selected @endif>
                                            العمليات
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-12">
                             <button type="submit"
                            class="btn btn-success btn-elevate btn-block ">بحث
                                <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
                                <span class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </span>
                                <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                                </span>
                            </button>
                        </div>
                        <!-- End col -->
                    </div>
                </form>
            </div>
        </div>
        <!--end::Portlet-->
        <div class="row">
            <div class="col s12" id="the_error">

            </div>
        </div>
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-sign icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        عرض الاتصالات
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body ">
                <!-- Start Table  -->
                <div class="table-responsive">

                    <table class="table table-bordered table-hover ">
                        <thead>
                        <tr class="text-center">

                            @if(collect($coulmn)->contains('id'))
                                <th style="width: 5%">
                                    #
                                </th>@endif
                            @if(collect($coulmn)->contains('family'))
                                <th style="width: 20%;">المكفول
                                </th>@endif
                            @if(collect($coulmn)->contains('sponsor'))
                                <th style="width: 20%;">الكافل
                                </th>@endif
                            @if(collect($coulmn)->contains('reason'))
                                <th style="width: 15%">سبب الاتصال
                                </th>@endif
                            @if(collect($coulmn)->contains('status'))
                                <th style="width: 5%;">الحالة
                                </th>@endif
                            @if(collect($coulmn)->contains('admin'))
                                <th style="width: 15%;">مدخل الاتصال
                                </th>@endif
                            @if(collect($coulmn)->contains('his_date'))
                                <th style="width: 15%;">تاريخ الاتصال
                                </th>@endif
                            @if(collect($coulmn)->contains('operations'))
                                <th style="width: 5%;">العمليات
                                </th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($calls as $item)
                            <tr class="text-center">


                                @if(collect($coulmn)->contains('id'))
                                    <td>{{ $item->id }}</td>@endif
                                @if(collect($coulmn)->contains('family'))
                                    <td>{{$item->family->person->full_name}}</td>@endif
                                @if(collect($coulmn)->contains('sponsor'))
                                    <td>{{$item->sponsor->name}}-{{$item->sponsor->code}}</td>@endif
                                @if(collect($coulmn)->contains('reason'))
                                    <td>{{$item->reason}}</td>@endif
                                @if(collect($coulmn)->contains('status'))
                                    <td>{{$item->status?"تمت":"لم تتم"}}</td>
                                    </td>@endif
                                @if(collect($coulmn)->contains('admin'))
                                    <td>{{\App\User::find($item->created_by)->full_name}}</td>@endif
                                @if(collect($coulmn)->contains('his_date'))
                                    <td>{{$item->his_date?date('d-m-Y', strtotime($item->his_date)):""}}</td>@endif
                                @if(collect($coulmn)->contains('operations'))
                                    <td>
                                        <div class="dropdown dropdown-inline">
                                            <button type="button"
                                                    class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="la la-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="/admin/calls/{{$item->id}}/edit"><i
                                                            class="fa fa-pen"></i>
                                                    تعديل
                                                </a>
                                                <a class="dropdown-item" href="/admin/calls/{{$item->id}}">
                                                    <i class="fa fa-shopping-bag"></i>
                                                    عرض</a>
                                                <a class="dropdown-item Confirm"
                                                   href="/admin/calls/delete/{{$item->id}}">
                                                    <i class="fa fa-trash"></i>
                                                    حذف</a>
                                            </div>
                                        </div>
                                    </td>@endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table  -->
                <!--begin: Pagination-->
            {{$calls->links()}}

            <!--end: Pagination-->
            </div>
        </div>
        <!--end::Portlet-->
    </div>
@endsection

@section('select2')
 <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
    
    <script>
        $("#selUser").select2({
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

    <script>
        $("#selUser2").select2({
            multiple: true,
            ajax: {
                url: "/admin/sponsors/sponsors_ajax",
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