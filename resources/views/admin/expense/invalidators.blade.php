@extends('layouts.dashboard.app')

@section('pageTitle','اكمال معلومات الصرفية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الصرفيات')
@section('navigation3','المبطلين بعد الصرفية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expenses')
@section('navigation3_link','#')
@section('content')
    @if(!request('first'))
        <div class="col-lg-12 col-xl-12">
            <div class="alert alert-success fade show" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                @if(($invalidators) &&$invalidators->first())
                    <div class="alert-text">
                        تم إبطال {{$invalidators->count()}} اسرة
                        {{$expense_name}}
                    </div>
                @else
                    <div class="alert-text">
                        <a href="/admin/expenses">
                            لم يتم إبطال إي أسرة، انتقل لإدارة الصرفيات
                            {{$expense_name}}
                        </a>
                    </div>
                @endif
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
            @if($error_string)
                <div class="alert alert-danger fade show" role="alert" style="text-align: right;padding-top: 0;">
                    {!! $error_string !!}

                </div>
                <div class="alert alert-success fade show" style="min-height: 0;">
                    <div class="row">

                        <form method="post" action="{{ url('admin/expenses/exportIgnoreFile') }}">
                            @csrf
                            <input name="file_name" type="hidden"
                                   value="{{ \App\Expense::find($expense_id)->old_name }}">
                            <input name="faild_collection" type="hidden" value="{{$faild_collection}}">
                            <div class="col s12">
                                <button type="submit" class="btn btn-danger btn-elevate">تحميل الصفوف التي
                                    فشل إضافتها
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            @if($note_string)
                <div class="alert alert-warning fade show" role="alert" style="text-align: right;padding-top: 0;">
                    {!! $note_string !!}
                </div>
        @endif
        <!--begin::Portlet-->
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <span class="fa fa-pen icon-padding"></span>
                        <h3 class="kt-portlet__head-title">
                            إبطال العائلات
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div id="required-error">
                    </div>
                    @if(($invalidators) && $invalidators->first())
                        <form action="/admin/expenses/invalidators" method="post">
                            @csrf
                            <input type="hidden" name="expense_id" value="{{$expense_id}}">
                            <!-- Start Row -->
                            @foreach($invalidators as $family)
                                <div class="row">
                                    <!-- Start col -->
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12">اسم الاسرة</label>
                                            <div style="width: 95%;">
                                                <input class="form-control"
                                                       id="name"
                                                       required
                                                       value="  {{$family->person->full_name ?? $family->code}} "
                                                       type="text"
                                                       placeholder="اسم الاسرة">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End col -->
                                    <!-- Start col -->
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12">تاريخ الإبطال</label>
                                            <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd"
                                                   readonly="readonly" type="text"
                                                   required
                                                   name="ignore_date[{{$family->id}}]"
                                                   value="{{old("ignore_date")[$family->id] ? $family->ignore_date : \Carbon\Carbon::today()->toDateString()}}"
                                                   style="width: 95%">
                                        </div>
                                    </div>
                                    <!-- End col -->

                                    <!-- Start col -->
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12">سبب الإبطال</label>
                                            <textarea class="form-control" id="representative_reason" rows="4"
                                                      required
                                                      name="note[{{$family->id}}]"
                                                      style="height: 150px; width: 98%;">
                                            {{old("note")[$family->id] ?? $family->note}}
                                        </textarea>
                                        </div>
                                    </div>
                                    <!-- End col -->

                                </div>

                                <hr style="width: 100%">
                        @endforeach
                        <!-- End Row -->
                            <!-- Satrt Button Confirm -->
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success btn-elevate btn-block ">تأكيد الحفظ وانتقال
                                    لإدارة
                                    الصرفيات
                                    <i id="wating" style="display: none" class="fas fa-circle-notch fa-spin"></i>

                                </button>
                            </div>
                            <!-- End Button Confirm -->
                        </form>
                    @endif
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    @endif
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
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection