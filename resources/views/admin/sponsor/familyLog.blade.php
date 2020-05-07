@extends('layouts.dashboard.app')
@section('pageTitle','إدارة الاستمارات والزيارات')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}">
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/dataTables.checkboxes.css') }}">
    <style>
        [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
            opacity: 1;
        }

        #disease_type_div [type="checkbox"]:not(:checked), #disease_type_div [type="checkbox"]:checked {
            opacity: 0 !important;
        }

        .dataTables_filter label {
            display: none !important;
        }
    </style>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الاستمارات والزيارات')

@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/families')

@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        استمارات الكافل {{$sponsor->name}}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">

            </div>
        </div>
        <!--end::Portlet-->
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">

            <div class="kt-portlet__body">
                <!-- Start Table  -->
                <table class="table table-bordered table-hover" id="table">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>الصوره</th>
                        <th>الاسم كامل</th>
                        <th>الكود</th>
                        <th>الهوية</th>
                        <th>تصنيف الحالة</th>
                        <th>السكن</th>
                        <th>عدد الافراد</th>
                        <th> الحالة الدراسية</th>
                        <th> الحالة الوظيفية</th>
                        <th> الحالة الاجتماعية</th>
                        <th> الوضع الصحي</th>
                        <th>المعيل</th>
                        <th>مبلغ الدخل</th>
                        <th>جهة الدخل</th>
                        <th>تقييم الحالة</th>
                        <th>قيمة الساعة الدراسية</th>
                        <th>اسم الموسسة التعليمية</th>
                        <th>نوع الزيارة</th>
                        <th>وضع الحالة</th>
                        <th>اجمالي عدد الزيارات</th>
                        <th>الزيارات الميدانية للباحث</th>
                        <th>الترجمة</th>
                        <th>الجهة المرشحة</th>
                        <th> المشروع</th>
                        <th> نوع الكفالة</th>
                        <th> سنه الزيارة</th>
                        <th> شهر الزيارة</th>
                        <th> يوم الزيارة</th>
                        <th> تاريخ الزيارة</th>
                        <th>اكتمال البيانات</th>
                        <th> الارسال</th>
                        <th> التقييم</th>
                        <th> الامراض</th>
                        <th width="40%">العمليات</th>
                    </tr>
                    </thead>

                </table>
                <!-- End Table  -->
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
    <script src="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <script type="text/javascript"
            src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
    <script>

        jQuery(document).ready(function () {

            var url = "{{ url('admin/sponsors/family_log_data/'.$sponsor->id) }}";

            var table = $('#table').DataTable({
                responsive: true,
                processing: true,
                order: [[0, "desc"]],
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'colvis',
                        text: 'فلتر الاعمدة'
                    }
                ],
                'select': {
                    'style': 'multi'
                },
                ajax: {
                    url: url,
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    }
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                },

                columns: [
                    {data: 'id', name: 'id', width: '5%'},
                    {data: 'image', name: 'image', width: '5%'},
                    {data: 'name', name: 'name', width: '25%'},
                    {data: 'code', name: 'code'},
                    {data: 'id_number', name: 'id_number'},
                    {data: 'family_type', name: 'family_type'},
                    {data: 'house', name: 'house'},
                    {data: 'member_count', name: 'member_count'},
                    {data: 'qualification', name: 'qualification'},
                    {data: 'work', name: 'work'},
                    {data: 'social_status', name: 'social_status'},
                    {data: 'health_status', name: 'health_status'},
                    {data: 'breadwinner', name: 'breadwinner'},
                    {data: 'income_value', name: 'income_value'},
                    {data: 'job_type', name: 'job_type'},
                    {data: 'need', name: 'need'},
                    {data: 'hour_price', name: 'hour_price'},
                    {data: 'educational_institution', name: 'educational_institution'},
                    {data: 'visit_reason', name: 'visit_reason'},
                    {data: 'status', name: 'status'},
                    {data: 'visit_count', name: 'visit_count'},
                    {data: 'searcher', name: 'searcher'},
                    {data: 'translation', name: 'translation'},
                    {data: 'funded_institution', name: 'funded_institution'},
                    {data: 'project', name: 'project'},
                    {data: 'classification', name: 'classification'},
                    {data: 'visit_year', name: 'visit_year'},
                    {data: 'visit_month', name: 'visit_month'},
                    {data: 'visit_day', name: 'visit_day'},
                    {data: 'visit_date', name: 'visit_date'},
                    {data: 'complete', name: 'complete'},
                    {data: 'sent', name: 'sent'},
                    {data: 'note_turkey', name: 'note_turkey'},
                    {data: 'disease', name: 'disease'},
                    {data: 'actions', name: 'actions', width: '10%'},
                ],

                "columnDefs": [
                    {
                        "targets": [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 19, 21, 22, 23, 24, 25, 26, 27, 33, 32],
                        "visible": false,
                    },
                    {
                        targets: 0,
                        checkboxes: {
                            selectRow: true
                        }
                    }
                ],

                initComplete: function () {
                    console.log('soso');
                }
            });

            $('#main_form').on('submit', function (e) {
                var form = this;
                $('input[name="id\[\]"]', form).remove();
                var rows_selected = table.column(0).checkboxes.selected();

                // Iterate over all selected checkboxes
                $.each(rows_selected, function (index, rowId) {
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'id[]')
                            .val(rowId)
                    );
                });
            });

            $('#name').on('keyup', function () {
                table.columns(2).search(this.value).draw();
            });

            $('#code').on('keyup', function () {
                table.columns(3).search(this.value).draw();
            });

            $('#id_number').on('keyup', function () {
                table.columns(4).search(this.value).draw();
            });

            $('#type').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(5).search(val ? '^' + val + '$' : '', true, false).draw();
            });
            $('#houseOwnerShip').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(6).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#member_count').on('keyup', function () {
                table.columns(7).search(this.value).draw();
            });

            $('#qualification').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(8).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#work').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(9).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#socialStatus').on('change', function () {
                table.columns(10).search(this.value).draw();
            });

            $('#health').on('change', function () {
                table.columns(11).search(this.value).draw();
            });

            $('#relationship').on('change', function () {
                table.columns(12).search(this.value).draw();
            });

            $('#income_value').on('keyup', function () {
                table.columns(13).search(this.value).draw();
            });


            $('#jobType').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(14).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#need').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(15).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#hour_price').on('keyup', function () {
                table.columns(16).search(this.value).draw();
            });

            $('#educationalInstitution').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(17).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#visitReason').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(18).search(val ? '^' + val + '$' : '', true, false).draw();
            });


            $('#familyStatus').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(19).search(val ? '^' + val + '$' : '', true, false).draw();
            });


            $('#visit_count').on('keyup', function () {
                table.columns(20).search(this.value).draw();
            });

            $('#searcher').on('change', function () {
                var search = [];
                var val;
                $.each($('#searcher option:selected'), function () {
                    val = $.fn.dataTable.util.escapeRegex($(this).val());
                    search.push(val);
                });

                search = search.join('|');

                table.column(21).search(search, true, false).draw();
            });

            $('#translation').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(22).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#fundedInstitutions').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(23).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#project').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(24).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#family_classification').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(25).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#year').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(26).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#month').on('change', function () {

                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(27).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#day').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(28).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#complete').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(30).search(val ? '^' + val + '$' : '', true, false).draw();
            });


            $('#sent').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(31).search(val ? '^' + val + '$' : '', true, false).draw();
            });


            $('#note_turkey').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(32).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#disease').on('change', function () {
                var search = [];
                var val;
                $.each($('#disease option:selected'), function () {
                    val = $.fn.dataTable.util.escapeRegex($(this).val());
                    search.push(val);
                });

                search = search.join('|');

                table.column(33).search(search, true, false).draw();
            });


            $(function () {
                $("#datepicker_from").datepicker({
                    todayBtn: 'linked',
                    format: 'yyyy-mm-dd',
                    buttonImageOnly: false,
                    "onSelect": function (date) {
                        dateString = new Date(date);
                        minDateFilter =
                            ("0" + dateString.getUTCDate()).slice(-2) + "/" +
                            ("0" + (dateString.getUTCMonth() + 1)).slice(-2) + "/" +
                            dateString.getUTCFullYear();

                        table.draw();
                    }
                }).keyup(function () {
                    dateString = new Date(date);
                    minDateFilter =
                        ("0" + dateString.getUTCDate()).slice(-2) + "/" +
                        ("0" + (dateString.getUTCMonth() + 1)).slice(-2) + "/" +
                        dateString.getUTCFullYear();

                    table.draw();
                });

                $("#datepicker_to").datepicker({
                    // showOn: "button",
                    todayBtn: 'linked',
                    format: 'yyyy-mm-dd',
                    "onSelect": function (date) {
                        dateString = new Date(date);
                        maxDateFilter =
                            ("0" + dateString.getUTCDate()).slice(-2) + "/" +
                            ("0" + (dateString.getUTCMonth() + 1)).slice(-2) + "/" +
                            dateString.getUTCFullYear();

                        console.log(maxDateFilter);
                        table.draw();
                    }
                }).keyup(function () {
                    dateString = new Date(date);
                    maxDateFilter =
                        ("0" + dateString.getUTCDate()).slice(-2) + "/" +
                        ("0" + (dateString.getUTCMonth() + 1)).slice(-2) + "/" +
                        dateString.getUTCFullYear();

                    table.draw();
                });


                // Date range filter
                minDateFilter = "";
                maxDateFilter = "";
                $.fn.dataTableExt.afnFiltering.push(
                    function (oSettings, aData, iDataIndex) {

                        if (typeof aData._date == 'undefined') {
                            aData._date = new Date(aData[0]).getTime();
                        }

                        if (minDateFilter && !isNaN(minDateFilter)) {
                            if (aData._date < minDateFilter) {
                                return false;
                            }
                        }

                        if (maxDateFilter && !isNaN(maxDateFilter)) {
                            if (aData._date > maxDateFilter) {
                                return false;
                            }
                        }

                        return true;
                    }
                );
            });


        });


        $('#table').on('draw.dt', function () {
            $('.dropdown-trigger').dropdown();
        });

        function load_data() {

            var fromID = $('#fromID').val();
            var toID = $('#toID').val();

            if (fromID > toID) {
                alert('العدد الثاني اقل من العدد الأول')
            }


            $('#IDFilter').click(function () {
                $('#table').DataTable().clear();
                $('#table').DataTable().destroy();
                load_data();
            });

            $('#DateFilter').click(function () {
                $('#table').DataTable().clear();
                $('#table').DataTable().destroy();
                load_data();
            });
        }

    </script>
@endsection


