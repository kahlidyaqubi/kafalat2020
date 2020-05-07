@extends('layouts.dashboard.app')

@section('pageTitle','إدارة حركات النظام')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}">
    <style>

        .dataTables_wrapper table.dataTable.dtr-inline.collapsed > tbody > tr[role="row"] > td:first-child:before {
            float: right;
            margin: -5px 5px;
        }

        th.big-col {
            width: 200px !important;
        }

        th.big-col-400 {
            width: 400px !important;
        }

        table#table {
            table-layout: fixed;
        }

        #table_filter, #table_paginate {
            float: left;
        }

        label {
            display: inline-flex !important;
        }

        label select {
            margin: -5px 5px;
        }
    </style>

@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة حركات النظام')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/logs')
@section('content')
    <div class="col-lg-12">

        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        إدارة حركات النظام
                    </h3>
                </div>
            </div>

            <div class="p-5">
            <!--            <div class="row">

                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <div style="width: 95%;">
                                <label class="col-form-label col-lg-12">المستخدم</label>
                                <select class="form-control " id="users">
                                    <option value=" "> المستخدم</option>
                                    @foreach(\App\User::orderBy('full_name')->get() as $item)
                <option value="{{ $item->full_name }}">{{ $item->full_name }}</option>
                                    @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="form-group row">
                <div style="width: 95%;">
                    <label class="col-form-label col-lg-12">نوع الحركة</label>
                    <select class="form-control " id="logTable_filter">
                        <option value=" "> أنواع الحركات</option>
@foreach(\App\LogCategory::orderBy('name')->get() as $item)
                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group row">
                <label class="col-form-label col-lg-12">التاريخ من</label>
                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                       id="min" name="min" style="width: 95%">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group row">
                <label class="col-form-label col-lg-12">التاريخ إلى</label>
                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text" id="max"
                       name="max" style="width: 95%">
            </div>
        </div>
    </div>
-->
                <table id="table"
                       class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap"
                       cellspacing="0"
                       width="100%">
                    <thead class="thead-light">
                    <tr>
                        <th class="big-col">التاريخ</th>
                        <th class="big-col">الوقت</th>
                        <th class="big-col-400">الحركه</th>
                        <th class="big-col">نوع الحركه</th>
                        <th class="big-col">المستخدم</th>
                        <th class="big-col">عنوان IP</th>
                        <th class="big-col">بيانات المتصفح</th>
                        <th>الجهاز</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
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
    <script src="{{ asset('assets/plugins/datatables/datatables.bundle.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js"></script>
    <script>
        var url = "{{ url('admin/logs/getLogs') }}";
        jQuery(document).ready(function () {

            var table = $('#table').DataTable({
                responsive: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                },
                "processing": true,
                "order": [[0, "desc"]],
                "lengthChange": false,
                "searching": true,
                "serverSide": true,
                "ajax": url,
                columns: [
                    {data: 'date', name: 'date', width: '5%'},
                    {data: 'time', name: 'time', width: '5%'},
                    {data: 'message', name: 'message', width: '50%'},
                    {data: 'category', name: 'category', width: '25%'},
                    {data: 'user', name: 'user', width: '5%'},
                    {data: 'ip_address', name: 'ip_address'},
                    {data: 'agent', name: 'agent', width: 200},
                    {data: 'device', name: 'device'},
                ],

            });
            /************************/
           /* $('#filter').click(function () {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if (from_date != '' && to_date != '') {
                    $('#table').DataTable().destroy();
                    table.draw();
                } else {
                    alert('Both Date is required');
                }
            });
            $.fn.dataTable.moment('Y-m-d');
            $('#from').keyup(function () {
                console.log('herer');
                table.draw();
            });
            $('#to').keyup(function () {
                table.draw();
            });
            $('#logTable_filter').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(3).search(val ? '^' + val + '$' : '', true, false).draw();
            });
            $('#users').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(1).search(val ? '^' + val + '$' : '', true, false).draw();
            });
            $('#table').on('draw.dt', function () {
                $('.dropdown-trigger').dropdown();
                $('select').formSelect();

            });*/
        });

    </script>

@endsection