@extends('layouts.dashboard.app')

@section('pageTitle',"تعديل صلاحيات حساب ".$user->first_name." ".$user->family_name)
@section('headerCSS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','المستخدمين')
@section('navigation3','تعديل صلاحيات مستخدم')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/users')
@section('navigation3_link','/admin/users/permission/'.$user->id.'')
@section('content')


    <div class="col-lg-12">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        تعديل صلاحيات {{$user->first_name}} {{$user->family_name}}
                    </h3>
                </div>
            </div>
            <!--begin::Form   id="kt_form_1"-->
            <form class="kt-form kt-form--label-right" method="post" action="/admin/users/permission/{{$user->id}}"
                  class="form-horizontal">
                @csrf
                <div class="kt-portlet__body">

                    <label class="kt-checkbox row"><input
                                type="checkbox" id="#checkAll" onClick="toggle(this)" /><B> تحديد الكل </B> <span></span> </label>

                    <b class="col-md-12">الصلاحيات الرئيسية</b>
                    <div class="row">
                        @foreach($links as $link)

                            <div class="col col-form-label kt-checkbox mb-5 ">
                                <label class="kt-checkbox">
                                    <input
                                            {{$user->hasPermissionTo($link->id)?'checked':''}} type="checkbox"
                                            name="permissions[]" value="{{$link->id}}"/>
                                    <b>{{$link->title}}</b>
                                    <span></span></label>
                                <div class="kt-checkbox-list the_parent">
                                    <?php
                                    $sublinks = \Spatie\Permission\Models\Permission::where("parent_id", $link->id)->get();
                                    ?>

                                    @foreach($sublinks as $sublink)
                                        <li class="list-unstyled">
                                            <label class="kt-checkbox">
                                                <input {{$user->hasPermissionTo($sublink->id)?'checked':''}}
                                                       type="checkbox" name="permissions[]"
                                                       value="{{$sublink->id}}"/> {{$sublink->title}}
                                                <span></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </div>
                            </div>

                        @endforeach
                    </div>
                    <hr class="col-md-12">
                    <b class="col-md-12">صلاحيات المساعدات</b>

                    <div class="row">
                        @foreach($coupon_links as $link)
                            <div class="col col-form-label kt-checkbox mb-5 ">
                                <label label class="kt-checkbox">
                                    <input
                                            {{$user->hasPermissionTo($link->id)?'checked':''}} type="checkbox"
                                            name="permissions[]" value="{{$link->id}}"/>
                                    <b>{{$link->title}}</b>
                                    <span></span></label>
                                <div class="kt-checkbox-list">
                                    <?php
                                    $sublinks = \Spatie\Permission\Models\Permission::where("parent_id", $link->id)->get();
                                    ?>

                                    @foreach($sublinks as $sublink)
                                        <li class="list-unstyled">
                                            <label class="kt-checkbox">
                                                <input {{$user->hasPermissionTo($sublink->id)?'checked':''}}
                                                       type="checkbox" name="permissions[]"
                                                       value="{{$sublink->id}}"/> {{$sublink->title}}
                                                <span></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr class="col-md-12">
                    <b class="col-md-12">صلاحيات إدارة النظام</b>

                    <div class="row">
                        @foreach($sitting_links as $link)
                            <div class="col col-form-label kt-checkbox mb-5 ">
                                <label class="kt-checkbox">
                                    <input
                                            {{$user->hasPermissionTo($link->id)?'checked':''}} type="checkbox"
                                            name="permissions[]" value="{{$link->id}}"/>
                                    <b>{{$link->title}}</b>
                                    <span></span></label>
                                <div class="kt-checkbox-list">
                                    <?php
                                    $sublinks = \Spatie\Permission\Models\Permission::where("parent_id", $link->id)->get();
                                    ?>

                                    @foreach($sublinks as $sublink)
                                        <li class="list-unstyled">
                                            <label class="kt-checkbox">
                                                <input {{$user->hasPermissionTo($sublink->id)?'checked':''}}
                                                       type="checkbox" name="permissions[]"
                                                       value="{{$sublink->id}}"/> {{$sublink->title}}
                                                <span></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr class="col-md-12">

                    <b class="col-md-12">صلاحيات القوائم المنسدلة</b>

                    <div class="row">
                        @foreach($lists_links as $link)
                            <div class="col-md-2 col-form-label kt-checkbox mb-5 ">
                                <label class="kt-checkbox">
                                    <input
                                            {{$user->hasPermissionTo($link->id)?'checked':''}} type="checkbox"
                                            name="permissions[]" value="{{$link->id}}"/>
                                    <b>{{$link->title}}</b>
                                    <span></span></label>
                                <div class="kt-checkbox-list">
                                    <?php
                                    $sublinks = \Spatie\Permission\Models\Permission::where("parent_id", $link->id)->get();
                                    ?>

                                    @foreach($sublinks as $sublink)
                                        <li class="list-unstyled">
                                            <label class="kt-checkbox">
                                                <input {{$user->hasPermissionTo($sublink->id)?'checked':''}}
                                                       type="checkbox" name="permissions[]"
                                                       value="{{$sublink->id}}"/> {{$sublink->title}}
                                                <span></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit"
                                    class="btn btn-success btn-elevate btn-block ">حفظ
                                <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
                                    <span class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </span>
                                    <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                                </span>
                            </button>
                                    <br/>
                                    <a href="\admin\users" class="btn btn-secondary col-12">إلغاء</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!--end::Form-->
        </div>

        <!--end::Portlet-->
    </div>




@endsection

@section('footerJS')
    <script>
        $(function () {

            $(":checkbox").click(function () {
                $(this).parent().next().find(":checkbox").prop("checked", $(this).prop("checked"));
                $(this).parents(".the_parent").each(function () {
                    $(this).prev().children(":checkbox").prop("checked", $(this).find(":checked").length > 0);
                });

            });
//
            //
        });
        function toggle(source) {
            checkboxes = $(":checkbox");
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
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