@extends('layouts.dashboard.app')

@section('pageTitle','إدارة جهات ترخيص')
@section('headerCSS')
@endsection

@section('navigation1','الرئيسية')
@section('navigation3','إدارة جهات ترخيص')
@section('navigation1_link','/admin/home')
@section('navigation3_link','/admin/licensors')
@section('navigation2','إعدادت عامة')
@section('navigation2_link','/admin/all_settings')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إدارة الجهات ترخيص
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
                                <label class="col-form-label col-lg-12">بحث من خلال اسم الجهة ترخيص</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" اكتب العنوان  " id="name" name="name"
                                           value="{{$name}}"
                                           type="text">
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
                                        <option value="1" @if($status == 1)selected @endif> مقبول</option>
                                        <option value="0" @if($status === '0')selected @endif> غير مقبول</option>
                                    </select>
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
                        عرض الجهات ترخيص
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
                            <th style="width: 20%;">اسم الجهة ترخيص
                            </th>
                            <th style="width: 5%;">الحالة
                            </th>
                            <th style="width: 5%;">العمليات
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($licensors as $item)
                            <tr class="text-center">
                                <td>
                                    {{ $item->id }}</td>
                                <td>{{$item->name}}</td>

                                <td>
                                    <div class="">
                            <span
                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                <label>
                                    <input class="cbActive" type="checkbox"
                                           @if(auth()->user()->hasPermissionTo(231))
                                           {{$item->status?"checked":" "}} value="{{$item->id}}"
                                           @else
                                           {{$item->status?"checked":" "}}disabled
                                           title="لا تملك صلاحية اعتماد جهة ترخيص"
                                           value="{{$item->id}}"
                            @endif>
                                    <span></span>
                                </label>
                            </span>
                                    </div>
                                </td>
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
                                            <a class="dropdown-item" href="/admin/licensors/{{$item->id}}/edit"><i
                                                        class="fa fa-pen"></i>
                                                تعديل
                                            </a>
                                            <a class="dropdown-item"
                                               href="/admin/institutions?licensor_ids[]={{$item->id}}"><i
                                                        class="fa fa-pen"></i>
                                                الجمعيات
                                            </a>
                                            <a class="dropdown-item Confirm"
                                               href="/admin/licensors/delete/{{$item->id}}">
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
            {{$licensors->links()}}

            <!--end: Pagination-->
            </div>
        </div>
        <!--end::Portlet-->
    </div>
@endsection

@section('footerJS')



    <script>
        $(function () {
            $(".cbActive").change(function () {

                var id = $(this).val();
                var mythis = this;
                mythis.disabled = true;
                $.ajax({
                    url: "/admin/licensors/approve/" + id,
                    data: {_token: '{{ csrf_token() }}'},
                    success: function (resp) {
                        console.log(mythis);
                        document.getElementById("the_error").innerHTML = '<div class="alert alert-success alert-dismissible">\n' + resp.message +
                            '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '            <span aria-hidden="true">&times;</span>\n' +
                            '        </button>\n' +
                            '    </div>';

                        mythis.disabled = false;
                        console.log(mythis);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        document.getElementById("the_error").innerHTML = '<div class="alert alert-danger alert-dismissible">\n' + jqXHR.responseJSON.message +
                            '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '            <span aria-hidden="true">&times;</span>\n' +
                            '        </button>\n' +
                            '    </div>';
                        mythis.checked = !(mythis.checked);
                        mythis.disabled = false;
                    },
                });
            });

        });
    </script>
@endsection