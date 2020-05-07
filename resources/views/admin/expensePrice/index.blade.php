@extends('layouts.dashboard.app')

@section('pageTitle','إدارة أسعار الصرف')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة أسعار الصرف')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expense_prices')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إدارة أسعار الصرف
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form>
                    <div class="row">

                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ السعر من</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker" name="from_date" type="text"
                                           value="{{$from_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ السعر إلى</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker" name="to_date" type="text"
                                           value="{{$to_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- End col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">الجهة المرشحة</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="social_status_ids" name="funded_institution_ids[]" multiple="multiple">
                                        <option value=" ">الجهة المرشحة</option>
                                        @foreach($funded_institutions as $funded_institution)
                                            <option value="{{$funded_institution->id}}"
                                                    @if(in_array($funded_institution->id, $funded_institution_ids)) selected @endif>{{$funded_institution->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Start col -->
                        <div class="col-md-12">
                            <div class="form-group row">
                                <button type="submit"
                                        class="btn btn-success  col mr-3" name="theaction"
                                        value="search">بحث
                                </button>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                </form>
                <div class="row">

                    <form action="/admin/expense_prices/delete_group">
                        <input type="hidden" name="the_ids" id="myIds2">
                        <button type="submit"
                                class="btn btn-success col" name="theaction"
                                value="delete">حذف المحدد
                        </button>
                    </form>
                </div>
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
                        عرض أسعار الصرف
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body ">
                <!-- Start Table  -->
                <div class="table-responsive">

                    <table class="table table-bordered table-hover ">
                        <thead>
                        <tr class="text-center">

                            <th style="width: 5%">
                                #
                            </th>
                            <th>
                                <label class="kt-checkbox">
                                    <input type="checkbox" id="check_all" name="check_all" type="checkbox"
                                           value="1">الكل
                                    <span></span>
                                </label>
                            </th>
                            <th style="width: 20%;">الجهة المرشحة
                            </th>
                            <th style="width: 15%;">السنة
                            </th>
                            <th style="width: 5%">الشهر
                            </th>
                            <th>يورو لشكيل
                            </th>
                            <th>يورو لدولار
                            </th>
                            <th>دولار لشيكل
                            </th>
                            <th style="width: 5%;">العمليات
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expense_prices as $item)
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td>
                                    <div class="">
															<span
                                                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
																<label>
																	<input type="checkbox" id="{{$item->id}}"
                                                                           name="ids[{{$item->id}}]" type="checkbox"
                                                                           value="1">
																	<span></span>
																</label>
															</span>
                                    </div>
                                </td>
                                <td>{{$item->funded_institution->name}}</td>
                                <td>{{$item->year}}</td>
                                <td>{{$item->month->id}}</td>
                                <td>{{$item->euro_nis}}</td>
                                <td>{{$item->euro_usd}}</td>
                                <td>{{$item->usd_nis}}</td>
                                <td>
                                    <div class="dropdown dropdown-inline">
                                        <button type="button"
                                                class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                                data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="la la-cog"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="/admin/expense_prices/{{$item->id}}/edit">
                                                <i class="fa fa-shopping-bag"></i>
                                                تعديل</a>
                                            <a class="dropdown-item Confirm"
                                               href="/admin/expense_prices/delete/{{$item->id}}">
                                                <i class="fa fa-trash"></i>
                                                حذف</a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table  -->
                <!--begin: Pagination-->
            {{$expense_prices->links()}}

            <!--end: Pagination-->
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

        var ids_array = [];
        var ids = "";
        $("#check_all").change(function () {

            for (var z = 0; z < $('input[name^="ids"]').length; z++) {
                if ($("#check_all")[0].checked) {
                    $('input[name^="ids"]')[z].setAttribute('checked', 'checked');
                } else {
                    $('input[name^="ids"]')[z].removeAttribute('checked')
                }
                ids_array = [];
                $("input:checkbox[name^='ids']:checked").each(function () {
                    ids_array.push($(this).attr("id"));
                });
            }

            ids = ids_array.join();
            document.getElementById("myIds2").value = ids;
        });
        $('input[name^="ids"]').change(function () {
            ids_array = [];
            $("input:checkbox[name^='ids']:checked").each(function () {
                ids_array.push($(this).attr("id"));
            });
            ids = ids_array.join();
            document.getElementById("myIds2").value = ids;
        });
    </script>
    <script>
        $("[name='from_date']").datepicker({
            format: 'yyyy-mm',
            minViewMode: 1,
            orientation: "bottom auto"
        });
        $("[name='to_date']").datepicker({
            format: 'yyyy-mm',
            minViewMode: 1,
            orientation: "bottom auto"
        });
    </script>
@endsection