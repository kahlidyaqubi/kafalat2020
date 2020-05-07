@extends('layouts.dashboard.app')

@section('pageTitle','حركات المستخدم')
@section('headerCSS')
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

        table#logTable {
            table-layout: fixed;
        }

        #logTable_filter, #logTable_paginate {
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
@section('navigation2','إدارة المستخدمين')
@section('navigation3','حركات مستخدم')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/users')
@section('navigation3_link','/admin/users/getLog/'.$user->id.'')
@section('content')
    <div class="col-lg-12">

        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        حركات المستخدم {{$user->full_name}}
                    </h3>
                </div>
            </div>

            <div class="p-5">
                <table id="logTable"
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
    <script src="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        var url = "{{ url('admin/users/getLogs/'.$user->id) }}";
        jQuery(document).ready(function () {

            $('#logTable').DataTable({
                responsive: true,
                "processing": true,
                "order": [[0, "desc"]],
                "serverSide": true,
                "ajax": url,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                },
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
        });

    </script>

@endsection