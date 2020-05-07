@extends('layouts.dashboard.app')

@section('pageTitle','إدارة الجمعيات')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة الجمعيات')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/institutions')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إدارة الجمعيات
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
                                <label class="col-form-label col-lg-12">اسم الجمعية</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" اكتب الاسم  " id="name" name="name"
                                           value="{{$name}}"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">الشخص المسؤول</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" الشخص المسؤول  " id="responsible_person"
                                           name="responsible_person"
                                           value="{{$responsible_person}}" type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        

                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">الجوال أو الهاتف</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" اكتب الجوال أو الهاتف " id="the_mobile"
                                           name="the_mobile"
                                           value="{{$the_mobile}}"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
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
                        <div class="col-lg-4 col-md-6 col-sm-12">
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
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">عنوان الجمعية</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" اكتب العنوان " id="address"
                                           name="address"
                                           value="{{$address}}" type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">المحافظة</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="governorate_id" name="governorate_id" onchange="get_cities()">
                                        <option value=" " selected> المحافظة</option>
                                        @foreach($governorates->sortBy('name') as $governorate)
                                            <option value="{{$governorate->id}}"
                                                    @if($governorate->id==$governorate_id) selected @endif>{{$governorate->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">المدينة</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="city_id" name="city_id" onchange="get_neighborhoods()">
                                        <option value=" " selected> المدينة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">الحي
                                    </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="neighborhood_ids" name="neighborhood_ids[]" multiple="multiple">
                                        <option value=" " selected>الحي</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->


                        
                        
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">مجال عمل الجمعية
                                    </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="nstitution_type_ids" name="nstitution_type_ids[]" multiple="multiple">
                                        <option value=" ">اختر النوع</option>
                                        @foreach($institution_types as $institution_type)
                                            <option value="{{$institution_type->id}}"
                                                    @if(in_array($institution_type->id, $institution_type_ids)) selected @endif>{{$institution_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">فئات
                                        الاستهداف</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="target_types_ids" name="target_types_ids[]" multiple="multiple">
                                        <option value=" ">فئات الاستهداف</option>
                                        @foreach($target_types as $target_type)
                                            <option value="{{$target_type->id}}"
                                                    @if(in_array($target_type->id, $target_types_ids)) selected @endif>{{$target_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">جهات الترخيص </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="licensor_ids" name="licensor_ids[]"
                                            multiple="multiple">
                                        <option value=" "> جهة الترخيص</option>
                                        @foreach($licensors as $licensor)
                                            <option value="{{$licensor->id}}"
                                                    @if(in_array($licensor->id, $licensor_ids)) selected @endif>{{$licensor->name}}</option>
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
                                        <option value="name"
                                                @if(collect($coulmn)->contains('name'))selected @endif>
                                            الاسم
                                        </option>
                                        <option value="responsible_person"
                                                @if(collect($coulmn)->contains('responsible_person'))selected @endif>
                                            المسؤول
                                        </option>
                                        <option value="address"
                                                @if(collect($coulmn)->contains('address'))selected @endif>
                                            العنوان
                                        </option>
                                        <option value="mobile_one"
                                                @if(collect($coulmn)->contains('mobile_one'))selected @endif>
                                            جوال 1
                                        </option>
                                        <option value="mobile_two"
                                                @if(collect($coulmn)->contains('mobile_two'))selected @endif>
                                            جوال 2
                                        </option>
                                        <option value="mobile"
                                                @if(collect($coulmn)->contains('mobile'))selected @endif>
                                            هاتف أرضي
                                        </option>
                                        <option value="institution_type"
                                                @if(collect($coulmn)->contains('institution_type'))selected @endif>
                                            نوع الجمعية
                                        </option>
                                        <option value="licensor"
                                                @if(collect($coulmn)->contains('licensor'))selected @endif>
                                            جهة الترخيص
                                        </option>
                                        <option value="licensor_number"
                                                @if(collect($coulmn)->contains('licensor_number'))selected @endif>
                                            رقم الترخيص
                                        </option>
                                        <option value="target_type"
                                                @if(collect($coulmn)->contains('target_type'))selected @endif>
                                            فئات الاستهداف
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
                            <button type="submit"
                                      class="btn btn-success btn-elevate btn-block "name="theaction"
                                        value="search">بحث
                                    <span id="wating" class="" style="display: none">&nbsp;&nbsp;
                                        <span class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                        </span>
                                        <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                                </span>
                            </button>
                        </div>
                    <!-- End Button Confirm -->

                    </div>
                </form>
                <!-- Start Row -->
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
                        عرض الجمعيات
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
                            @if(collect($coulmn)->contains('name'))
                                <th style="width: 20%;">الاسم
                                </th>@endif
                            @if(collect($coulmn)->contains('responsible_person'))
                                <th style="width: 20%;">المسؤول
                                </th>@endif
                            @if(collect($coulmn)->contains('address'))
                                <th style="width: 101px;">العنوان
                                </th>@endif
                            @if(collect($coulmn)->contains('mobile_one'))
                                <th style="width: 15%;">جوال1
                                </th>@endif
                            @if(collect($coulmn)->contains('mobile_two'))
                                <th style="width: 15%;">جوال2
                                </th>@endif
                            @if(collect($coulmn)->contains('mobile'))
                                <th style="width: 15%;">هاتف أرض
                                </th>@endif
                            @if(collect($coulmn)->contains('institution_type'))
                                <th style="width: 5%;">نوع الجمعية
                                </th>@endif
                            @if(collect($coulmn)->contains('licensor'))
                                <th style="width: 5%;">جهة الترخيص
                                </th>@endif
                            @if(collect($coulmn)->contains('licensor_number'))
                                <th style="width: 5%;">رقم الترخيص
                                </th>@endif
                            @if(collect($coulmn)->contains('target_type'))
                                <th style="width: 5%;">فئة الاستهداف
                                </th>@endif
                            @if(collect($coulmn)->contains('operations'))
                                <th style="width: 10%;">العمليات
                                </th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($institutions as $item)
                            <tr class="text-center">


                                @if(collect($coulmn)->contains('id'))
                                    <td>{{ $item->id }}</td>@endif
                                @if(collect($coulmn)->contains('name'))
                                    <td>{{$item->name}}</td>@endif
                                @if(collect($coulmn)->contains('responsible_person'))
                                    <td>{{$item->responsible_person}}</td>@endif
                                @if(collect($coulmn)->contains('address'))
                                    <td>@if($item->neighborhood){{$item->neighborhood->name ?? ""}}
                                        /{{$item->neighborhood->city->name ?? ""}}
                                        / {{$item->neighborhood->city->governorate->name ?? ""}}
                                        / @endif {{$item->address}}</td>@endif
                                @if(collect($coulmn)->contains('mobile_one'))
                                    <td>{{$item->mobile_one}}</td>@endif
                                @if(collect($coulmn)->contains('mobile_two'))
                                    <td>{{$item->mobile_two}}</td>@endif
                                @if(collect($coulmn)->contains('mobile'))
                                    <td>{{$item->mobile}}</td>@endif
                                @if(collect($coulmn)->contains('institution_type'))
                                    <td>@if($item->institution_type){{$item->institution_type->name}}@endif</td>@endif
                                @if(collect($coulmn)->contains('licensor'))
                                    <td>@if($item->licensor){{$item->licensor->name}}@endif</td>@endif
                                @if(collect($coulmn)->contains('licensor_number'))
                                    <td>{{$item->licensor_number}}</td>@endif
                                @if(collect($coulmn)->contains('target_type'))
                                    <td>@if($item->target_types){{implode('- ',$item->target_types->pluck('name')->toArray() )}}@endif</td>@endif
                                @if(collect($coulmn)->contains('operations'))
                                    <td>
                                        <!-- <button type="button" class="btn btn-danger btn-elevate">حذف</button> -->
                                        <!-- <button type="button" class="btn btn-success btn-elevate ">تعديل</button> -->
                                        <div class="dropdown dropdown-inline">
                                            <button type="button"
                                                    class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="la la-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                   href="/admin/institutions/{{$item->id}}/edit"><i
                                                            class="fa fa-pen"></i>
                                                    تعديل
                                                </a>
                                                <a class="dropdown-item" href="/admin/season_coupons?funded_institutions_ids_yes[]={{$item->id}}">
                                                    <i class="fa fa-sign"></i>
                                                    المساعدات الموسمية</a>
                                                <a class="dropdown-item" href="/admin/urgent_coupons?funded_institutions_ids_yes[]={{$item->id}}"><i
                                                            class="fa fa-signal"></i>
                                                    المساعدات الطارئة</a>
                                                <a class="dropdown-item Confirm"
                                                   href="/admin/institutions/delete/{{$item->id}}">
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
            {{$institutions->links()}}

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
        $(document).ready(function () {

            var governorate_id = $("[name='governorate_id']").val();

            $.get("/admin/governorates/cities/" + governorate_id, function (data, status) {
                $("[name='city_id']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="cities" value=" " >جميع المدن</option>');

                data.forEach(function (city) {
                    var iselected = checktruefalse(city.id);
                    $("[name='city_id']")
                        .append($("<option class='cities'></option>")
                            .attr("value", city.id)
                            .text(city.name));

                    $('.cities[value="' + city.id + '"]')
                        .attr('selected', iselected);
                    get_neighborhoods();
                });


            });


        });

        function get_cities() {
            var governorate_id = $("[name='governorate_id']").val();
            $.get("/admin/governorates/cities/" + governorate_id, function (data, status) {
                $("[name='city_id']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="cities" value=" ">جميع المدن</option>');

                data.forEach(function (city) {
                    var iselected = checktruefalse(city.id);
                    $("[name='city_id']")
                        .append($("<option class='cities'></option>")
                            .attr("value", city.id)
                            .text(city.name));
                    $('.cities[value="' + city.id + '"]')
                        .attr('selected', iselected);

                });
            });

        }

        function checktruefalse(id) {

            if (id == '{{$city_id}}') {
                return true
            } else
                return false
        }
    </script>
    <script>
        $(document).ready(function () {

            var city_id = $("[name='city_id']").val();

            $.get("/admin/cities/neighborhoods/" + city_id, function (data, status) {
                if(typeof data=='object'){
                $("[name='neighborhood_ids[]']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="neighborhoods" value=" ">جميع الأحياء</option>');

                data.forEach(function (neighborhood) {
                    var iselected = checktruefalse2(neighborhood.id);
                    $("[name='neighborhood_ids[]']")
                        .append($("<option class='neighborhoods'></option>")
                            .attr("value", neighborhood.id)
                            .text(neighborhood.name));

                    $('.neighborhoods[value="' + neighborhood.id + '"]')
                        .attr('selected', iselected);

                });
                }
            });
        });

        function get_neighborhoods() {
            var city_id = $("[name='city_id']").val();

            $.get("/admin/cities/neighborhoods/" + city_id, function (data, status) {
                if(typeof data=='object'){
                $("[name='neighborhood_ids[]']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="neighborhoods" value=" ">جميع الأحياء</option>');

                data.forEach(function (neighborhood) {
                    var iselected = checktruefalse2(neighborhood.id);
                    $("[name='neighborhood_ids[]']")
                        .append($("<option class='neighborhoods'></option>")
                            .attr("value", neighborhood.id)
                            .text(neighborhood.name));
                    $('.neighborhoods[value="' + neighborhood.id + '"]')
                        .attr('selected', iselected);

                });
}
            });

        }

        function checktruefalse2(id) {
            var z = @json($neighborhood_ids);
            if (inArray("" + id, z)) {
                return true
            } else
                return false
        }

        function inArray(needle, haystack) {
            var length = haystack.length;
            for (var i = 0; i < length; i++) {
                if (haystack[i] == needle) return true;
            }
            return false;
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