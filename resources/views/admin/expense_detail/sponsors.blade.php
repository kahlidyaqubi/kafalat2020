@extends('layouts.dashboard.app')

@section('pageTitle','كفلاء الصرفية')
@section('headerCSS')
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','ادارة الكشوفات')
@section('navigation2','كفلاء الصرفية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expenseDetails')
@section('navigation3_link','/admin/expenseDetails/sponsor/'.$expense_detail->id)
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        كفلاء صرفية المكفول {{$expense_detail->family->person->full_name}}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form>
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">اسم الكافل</label>
                                <div style="width: 99%;">
                                    <input class="form-control" placeholder=" اكتب اسم الكافل  " id="name" name="name"
                                           value="{{$name}}"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">كود الكافل</label>
                                <div style="width: 99%;">
                                    <input class="form-control" placeholder=" اكتب كود الكافل  " id="code" name="code"
                                           value="{{$code}}"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">جوال الكافل</label>
                                <div style="width: 99%;">
                                    <input class="form-control" placeholder=" اكتب جوال الكافل  " id="mobile"
                                           name="mobile"
                                           value="{{$mobile}}"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">عدد المكفولين</label>
                                <div style="width: 99%;">
                                    <input class="form-control" type="number" name="families_count"
                                           value="{{$families_count}}"
                                           placeholder="عدد المكفولين">
                                </div>
                            </div>
                        </div>
                        <!-- Start col -->
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">من الرقم</label>
                                <div style="width: 99%;">
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
                                <div style="width: 99%;">
                                    <input class="form-control" type="number" name="to_id" value="{{$to_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">حالة الكافل
                                    </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="sponsor_status_ids" name="sponsor_status_ids[]" multiple="multiple">
                                        <option value=" ">اختر الحالة</option>
                                        @foreach($sponsor_statuses as $sponsor_status)
                                            <option value="{{$sponsor_status->id}}"
                                                    @if(in_array($sponsor_status->id, $sponsor_status_ids)) selected @endif>{{$sponsor_status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">دولة الكافل
                                    </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="country_ids" name="country_ids[]" multiple="multiple">
                                        <option value=" ">اختر الدولة</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}"
                                                    @if(in_array($country->id, $country_ids)) selected @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">تحديد الأعمدة المعروضة </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="coulmn" name="coulmn[]" multiple="multiple">
                                        <option value="id"
                                                @if(collect($coulmn)->contains('id'))selected @endif>#
                                        </option>
                                        <option value="select"
                                                @if(collect($coulmn)->contains('select'))selected @endif>تحديد
                                        </option>
                                        <option value="name"
                                                @if(collect($coulmn)->contains('name'))selected @endif>
                                            اسم الكافل
                                        </option>
                                        <option value="code"
                                                @if(collect($coulmn)->contains('code'))selected @endif>
                                            كود الكافل
                                        </option>
                                        <option value="mobile"
                                                @if(collect($coulmn)->contains('mobile'))selected @endif>
                                            رقم التواصل
                                        </option>
                                        <option value="country"
                                                @if(collect($coulmn)->contains('country'))selected @endif>
                                            الدولة
                                        </option>
                                        <option value="sponsor_status"
                                                @if(collect($coulmn)->contains('sponsor_status'))selected @endif>
                                            حالة الكافل
                                        </option>
                                        <option value="families_count"
                                                @if(collect($coulmn)->contains('families_count'))selected @endif>
                                            عدد المكفولين
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
                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <div class="form-group row">
                        <button type="submit"
                              class="btn btn-success btn-elevate btn-block ">بحث
                            <span id="wating" class="" style="display: none">&nbsp;&nbsp;
                                <span class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                                </span>
                                <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                        </span>
                        </button>
                    </div>
                </div>
                <!-- End Button Confirm -->

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
                        عرض الكفلاء
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
                                </th>
                            @endif
                            @if(collect($coulmn)->contains('name'))
                                <th style="width: 20%;">اسم الكافل
                                </th>@endif
                            @if(collect($coulmn)->contains('code'))
                                <th style="width: 20%;">كود الكافل
                                </th>@endif
                            @if(collect($coulmn)->contains('mobile'))
                                <th style="width: 15%">رقم التواصل
                                </th>@endif
                            @if(collect($coulmn)->contains('country'))
                                <th style="width: 5%;">الدولة
                                </th>@endif
                            @if(collect($coulmn)->contains('sponsor_status'))
                                <th style="width: 15%;">حالة الكافل
                                </th>@endif
                            @if(collect($coulmn)->contains('families_count'))
                                <th style="width: 15%;">عدد المكفولين
                                </th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sponsors as $item)
                            <tr class="text-center">
                                @if(collect($coulmn)->contains('id'))
                                    <td>{{ $item->id }}</td>@endif
                                @if(collect($coulmn)->contains('name'))
                                    <td>{{$item->name}}</td>@endif
                                @if(collect($coulmn)->contains('code'))
                                    <td>{{$item->code}}</td>@endif
                                @if(collect($coulmn)->contains('mobile'))
                                    <td>{{$item->mobile}}</td>@endif
                                @if(collect($coulmn)->contains('country'))
                                    <td>{{$item->country?$item->country->name:""}}</td>
                                    </td>@endif
                                @if(collect($coulmn)->contains('sponsor_status'))
                                    <td>{{$item->sponsor_status?$item->sponsor_status->name:""}}</td>@endif
                                @if(collect($coulmn)->contains('families_count'))
                                    <td>{{$item->expense_details_count}}</td>@endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table  -->
                <!--begin: Pagination-->
            {{$sponsors->links()}}

            <!--end: Pagination-->
            </div>
        </div>
        <!--end::Portlet-->
    </div>
@endsection

@section('footerJS')
     <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection