@extends('layouts.dashboard.app')

@section('pageTitle','ٕضافة افراد استمارة')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}">

@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الاستمارات')
@section('navigation3','ضافة افراد استمارة')
@section('navigation1_link','/admin/families')
@section('navigation2_link','/admin/families')
@section('navigation3_link','/admin/families/addMember/'.$family->id)
@section('content')
    @php
        $person = $family->person;
    @endphp
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        اضافة فرد استمارة
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <input id="family_id" name="family_id" hidden value="{{ $family->id }}">
                <!-- Start col -->
                <div class="col-lg-3 col-md-6 col-sm-12" style="margin-bottom: 20px;">
                    <button class="btn btn-success btn-elevate btn-block" data-toggle="modal" data-target="#add-user">
                        اضافة فرد جديد
                    </button>
                </div>
                <!-- End col -->
                <!-- Start Table  -->
                <table class="table table-bordered table-hover" id="member_table">
                    <thead>
                    <tr class="text-center">
                        <th>الاسم بالعربية</th>
                        <th>الاسم بالتركية</th>
                        <th>سنة الميلاد</th>
                        <th>رقم الهوية</th>
                        <th>صلة القرابة</th>
                        <th>الحالة الدراسية</th>
                        <th>الحالة الوظيفية</th>
                        <th>الحالة الصحية</th>
                        <th>الامراض</th>
                        <th>الحالة الاجتماعية</th>
                        <th>الحالة (سابقا)</th>
                        <th>العمليات</th>
                    </tr>
                    </thead>
                    <tbody id="addMemberTbody" class="text-center">
                    <tr>
                        <td>{{ !is_null($person->first_name) ? $person->first_name .' '. $person->family_name : '-' }}</td>
                        <td>{{ !is_null($person->first_name_tr) ? $person->first_name_tr : '-' }}</td>
                        <td>{{ !is_null($person->date_of_birth) ? $person->date_of_birth : '-' }}</td>
                        <td>{{ !is_null($person->id_number) ? $person->id_number : '-' }}</td>
                        <td>المكفول</td>
                        <td> {{ (isset($person->qualification)) && (!is_null($person->qualification)) ?  $person->qualification->name : '-' }} </td>
                        <td>{{ $person->work == 0 ? 'لايعمل' : 'يعمل' }}</td>
                        <td>{{ $person->health_status == 0 ? 'سليم' : 'مريض' }}</td>
                        <td> {{ (isset($person->social_status)) && (!is_null($person->social_status)) ?  $person->social_status->name : '-' }} </td>
                    </tr>
                    @if(isset($family->members))
                        @foreach($family->members->where('relationship_id' , '!=',14) as $member)
                            <tr>
                                @include('admin.family.part.member.addNew',$member)
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <!-- End Table  -->

            </div>
        </div>
        <!--end::Portlet-->

    </div>
    <div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">اضافة فرد جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="addMemberForm">
                    @csrf
                    <div class="modal-body">

                        <!-- Start row -->
                        <div class="row">
                            <!-- Start Col -->
                            <div class="col-lg-10 col-md-10">
                                <input type="text" class="form-control numbers" id="id_number_search" maxlength="9"
                                       name="id_number_search" placeholder="بحث عن طريق الهوية">
                            </div>
                            <!-- End Col -->
                            <!-- Start Col -->
                            <div class="col-lg-2 col-md-2">
                                <button type="button" class="btn btn-success btn-elevate btn-block"
                                        id="idNumberSearchButton">
                                    بحث
                                </button>
                            </div>
                            <!-- End Col -->
                            <div id="addMemberDiv" class="text-center"></div>
                        </div>
                        <!-- End row -->
                        <hr style="width: 100%">
                        <!-- Start row -->
                        <h6>البحث عن طريق تعبئة البيانات :</h6>

                        <div class="row">

                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الاسم الاول بالعربية</label>
                                        <input type="text" class="form-control arabic" id="member_first_name"
                                               name="member_first_name">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الاسم الاول بالتركية</label>
                                        <input type="text" class="form-control turkey" id="member_first_name_tr"
                                               name="member_first_name_tr">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الهوية</label>
                                        <input class="form-control numbers" id="member_id_number"
                                               name="member_id_number"
                                               maxlength="9">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة الاجتماعية</label>
                                        <select class="form-control kt-select2 select2-multi"
                                                id="member_social_status_id"
                                                name="member_social_status_id">
                                            <option value=" " selected> الحالة الاجتماعية</option>
                                            @foreach($socialStatuses as $socialStatus)
                                                <option value="{{ $socialStatus->id }}">{{ $socialStatus->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة الوظيفية</label>
                                        <select class="form-control kt-select2 select2-multi" name="member_work"
                                                id="member_work">
                                            <option value=" " selected>الحالة الوظيفية</option>
                                            <option value="1"> يعمل</option>
                                            <option value="0">لا يعمل</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة الصحية</label>
                                        <select class="form-control " id="member_health_status"
                                                name="member_health_status">
                                            <option value=" " selected>الحالة الصحية</option>
                                            <option value="1">مريض</option>
                                            <option value="0">سليم</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12" id="member_diseasesDiv">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الأمراض</label>
                                        <select class="form-control kt-select2 select2-multi" multiple
                                                id="member_family_diseases"
                                                name="member_family_diseases[]">
                                            <option value=" " disabled> الأمراض</option>
                                            @foreach($diseases as $disease)
                                                <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">سنة الميلاد</label>
                                        <input class="form-control datepicker" type="text"
                                               id="member_date_of_birth"
                                               name="member_date_of_birth"
                                               style="width: 95%">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">مكان الميلاد</label>
                                        <select class="form-control kt-select2 select2-multi" id="date_of_birth_place"
                                                name="date_of_birth_place">
                                            <option value=" " selected> مكان الميلاد</option>
                                            @foreach($countries as $country)

                                                <option value="{{ $country->id }}"
                                                        {{$country->name == 'فلسطين' ?'selected':''}} >{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة التعليمية</label>
                                        <select class="form-control kt-select2 select2-multi"
                                                name="member_qualification_id"
                                                id="member_qualification_id">
                                            <option value=" " selected>الحالة التعليمية</option>
                                            @foreach($qualifications as $qualification)
                                                <option value="{{ $qualification->id }}">{{ $qualification->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">صلة القرابة</label>
                                        <select class="form-control "
                                                name="member_relationship_id"
                                                id="member_relationship_id">
                                            <option value=" " selected> صلة القرابة</option>
                                            @foreach($relationships as $relationship)
                                                <option value="{{ $relationship->id }}">{{ $relationship->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12" id="member_relationship_div">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">صلة قرابة</label>
                                        <input type="text" class="form-control" id="member_relationship_other"
                                               name="member_relationship_other"
                                        >
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->

                        </div>
                        <!-- End row -->
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">
                            اغلاق
                        </button>
                        <button type="submit" id="addMemberButton" type="button" class="btn btn-success">حفظ</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-user" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        تعديل فرد </h5>
                    <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="editMemberForm">
                    @csrf
                    <div class="modal-body">

                        <div class="row">

                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الاسم
                                            الاول بالعربية</label>
                                        <input type="text"
                                               class="form-control arabic"
                                               id="member_first_name_edit"
                                               name="member_first_name">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الاسم
                                            الاول بالتركية</label>
                                        <input type="text"
                                               class="form-control turkey"
                                               id="member_first_name_tr_edit"
                                               name="member_first_name_tr">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الهوية</label>
                                        <input class="form-control numbers"
                                               id="member_id_number_edit"
                                               name="member_id_number"
                                               maxlength="9">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة
                                            الاجتماعية</label>
                                        <select class="form-control "
                                                id="member_social_status_id_edit"
                                                name="member_social_status_id">
                                            <option value=" " selected>
                                                الحالة الاجتماعية
                                            </option>
                                            @foreach($socialStatuses as $socialStatus)
                                                <option value="{{ $socialStatus->id }}">{{ $socialStatus->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة
                                            الوظيفية</label>
                                        <select class="form-control "
                                                name="member_work"
                                                id="member_work_edit">
                                            <option value=" " selected>
                                                الحالة الوظيفية
                                            </option>
                                            <option value="1"> يعمل
                                            </option>
                                            <option value="0">لا يعمل
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة
                                            الصحية

                                        </label>
                                        <select class="form-control "
                                                id="member_health_status_edit"
                                                name="member_health_status">
                                            <option value=" " selected>
                                                الحالة الصحية
                                            </option>
                                            <option value="1">مريض
                                            </option>
                                            <option value="0">سليم
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12" id="member_diseasesDiv">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الأمراض</label>
                                        <select class="form-control kt-select2 select2-multi"
                                                multiple
                                                id="member_family_diseases_edit"
                                                name="member_family_diseases[]">
                                            <option value=" " disabled>
                                                الأمراض
                                            </option>
                                            @foreach($diseases as $disease)
                                                <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">تاريخ
                                            الميلاد</label>
                                        <input class="form-control datepicker"
                                               type="text"
                                               id="member_date_of_birth_edit"
                                               name="member_date_of_birth"
                                               style="width: 95%">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">مكان
                                            الميلاد</label>
                                        <select class="form-control "
                                                id="member_date_of_birth_place_edit"
                                                name="member_date_of_birth_place">
                                            <option value=" " selected>
                                                مكان الميلاد
                                            </option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"
                                                        {{$country->name == 'فلسطين' ?'selected':''}}
                                                        {{ $country->id == $person->date_of_birth_place ? 'selected':'' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة
                                            التعليمية</label>
                                        <select class="form-control "
                                                name="member_qualification_id"
                                                id="member_qualification_id_edit">
                                            <option value=" " selected>
                                                الحالة التعليمية
                                            </option>
                                            @foreach($qualifications as $qualification)
                                                <option value="{{ $qualification->id }}">{{ $qualification->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">صلة
                                            القرابة</label>
                                        <select class="form-control "
                                                name="member_relationship_id"
                                                id="member_relationship_id_edit">
                                            <option value=" " selected>
                                                صلة القرابة
                                            </option>
                                            @foreach($relationships as $relationship)
                                                <option value="{{ $relationship->id }}">{{ $relationship->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12"
                                 id="member_relationship_div">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">صلة
                                            قرابة</label>
                                        <input type="text"
                                               class="form-control"
                                               id="member_relationship_other_edit"
                                               name="member_relationship_other"
                                        >
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->

                        </div>
                        <!-- End row -->
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                                data-dismiss="modal">
                            اغلاق
                        </button>
                        <button type="submit" id="editMemberButton"
                                type="button" class="btn btn-success">
                            حفظ
                        </button>
                    </div>

                </form>
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
    <script>
        //editRow
        function editRow(item) {

            var id = item.getAttribute('the_id');

            $.get("/admin/families/person_ajax_id?q=" + id, function (member, status) {

                arr = member.diseases;
                var new_arr = arr.map(function (value, index, array) {

                    return  value.id;

                });


                $("#member_first_name_edit").val(member.first_name);
                $("#member_first_name_tr_edit").val(member.first_name_tr);
                $("#member_id_number_edit").val(member.id_number);
                $("#member_social_status_id_edit").val(member.social_status_id);
                $("#member_work_edit").val(member.work);
                $("#member_health_status_edit").val(member.health_status);
                $("#member_family_diseases_edit").val(new_arr).change();
                $("#member_date_of_birth_edit").val(member.date_of_birth);
                $("#member_date_of_birth_place_edit").val(member.date_of_birth_place);
                $("#member_qualification_id_edit").val(member.qualification_id);
                $("#member_relationship_id_edit").val(member.member.relationship_id);
                $("#editMemberButton").val(member.id);

                console.log(new_arr);
                $("#edit-user").modal("show");
            });


            return false;

        };
        $('#editMemberButton').click(function (e) {
            e.preventDefault();
            var person_id = this.value;

            var addMemberUrl = '../../../admin/families/editNewMember/' + person_id + '/' + '{{$family->id}}'

            var member_social_status_id = $('#member_social_status_id_edit').val();
            var member_health_status = $('#member_health_status_edit').val();
            var member_work = $('#member_work_edit').val();
            var member_qualification_id = $('#member_qualification_id_edit').val();
            var member_relationship_id = $('#member_relationship_id_edit').val();
            var member_family_diseases = $('#member_family_diseases_edit').val();
            var member_id_number = $('#member_id_number_edit').val();
            var member_date_of_birth = $('#member_date_of_birth_edit').val();
            var member_date_of_birth_place = $('#member_date_of_birth_place_edit').val();
            var member_first_name = $('#member_first_name_edit').val();
            var member_first_name_tr = $('#member_first_name_tr_edit').val();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: addMemberUrl,
                data: {
                    "_token": "{{ csrf_token() }}",
                    member_social_status_id: member_social_status_id,
                    member_health_status: member_health_status,
                    member_work: member_work,
                    member_relationship_id: member_relationship_id,
                    member_qualification_id: member_qualification_id,
                    member_date_of_birth: member_date_of_birth,
                    member_id_number: member_id_number,
                    member_date_of_birth_place: member_date_of_birth_place,
                    member_first_name: member_first_name,
                    member_first_name_tr: member_first_name_tr,
                    member_family_diseases: member_family_diseases,

                }
            }).done(function (data) {
                if (data != 'error') {
                    $('#member_social_status_id_edit').val('');
                    $('#member_health_status_edit').val('');
                    $('#member_work_edit').val('');
                    $('#member_qualification_id_edit').val('');
                    $('#member_relationship_id_edit').val('');
                    $('#member_id_number_edit').val('');
                    $('#member_date_of_birth_edit').val('');
                    $('#member_first_name_edit').val('');
                    $('#member_first_name_tr_edit').val('');
                    $('#addMemberTbody').append(data.html);
                }
            });
        });
    </script>
    <script>
        $("[name='member_date_of_birth']").datepicker({
            format: 'yyyy',
            minViewMode: 2,
            orientation: "bottom auto"
        });
    </script>
    <script>
        $("#member_first_name_tr").click(function () {
            var name = $('#member_first_name').val();

            if (name != '') {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: url,
                    data: {name: name}
                }).done(function (transName) {

                    console.log(transName);
                    if ((transName == '') || (transName == null)) {
                        $('#member_first_name_tr').css('border-color', 'red');
                    } else {
                        $('#member_first_name_tr').val(transName);
                        $('#member_first_name_tr').css('border-color', 'green');
                    }
                });

            } else {
                $('#member_first_name_tr').css('border-color', 'red');
            }
        });
    </script>
    <script>
        $("body").on("click", "#idNumberSearchButton", function () {
            var form_action = '{{ url('admin/families/search/idNumber') }}';
            var text = $('#id_number_search').val();
            var family_id = $('#family_id').val();

            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: form_action,
                data: {text: text, family_id: family_id}
            }).done(function (data) {
                $('#addMemberDiv').empty();
                $('#addMemberDiv').append(data.html);

            });
        });


        // show hide health status select
        $('#member_diseasesDiv').hide();
        $("#member_health_status").change(function () {
            var id = $(this).children(":selected").attr("value");
            if (id == 1) {
                $('#member_diseasesDiv').show();
            } else if (id == 0) {
                $('#member_diseasesDiv').hide();

            }
        });

        // show hide relations
        $('#member_relationship_div').hide();
        $("#member_relationship_id").change(function () {
            var id = $(this).children(":selected").attr("value");
            $('#member_relationship_div').val('');

            if (id == 1) {
                $('#member_relationship_div').show();
            } else {
                $('#member_relationship_div').hide();
            }
        });

        $(".numbers").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 1632 || e.which > 1641)) {
                return false;
            }
        });

        var url = '{{ url('admin/families/add/getTranslation') }}';

        $("#member_first_name_tr_edit").click(function () {
            var name = $('#member_first_name_edit').val();

            if (name != '') {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: url,
                    data: {name: name}
                }).done(function (transName) {

                    console.log(transName);
                    if ((transName == '') || (transName == null)) {
                        $('#member_first_name_tr_edit').css('border-color', 'red');
                    } else {
                        $('#member_first_name_tr_edit').val(transName);
                        $('#member_first_name_tr_edit').css('border-color', 'green');
                    }
                });

            } else {
                $('#member_first_name_tr_edit').css('border-color', 'red');
            }
        });

        $("#member_first_name_tr").click(function () {
            var name = $('#member_first_name').val();

            if (name != '') {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: url,
                    data: {name: name}
                }).done(function (transName) {

                    if ((transName == '') || (transName == null)) {
                        $('#member_first_name_tr').css('border-color', 'red');
                    } else {
                        $('#member_first_name_tr').val(transName);
                        $('#member_first_name_tr').css('border-color', 'green');
                    }
                });

            } else {
                $('#member_first_name_tr').css('border-color', 'red');
            }
        });

        $('#addMemberForm').submit(function (e) {
            e.preventDefault();
            var addMemberUrl = '{{ url('admin/families/addNewMember/'.$family->id) }}';

            var member_social_status_id = $('#member_social_status_id').val();
            var member_health_status = $('#member_health_status').val();
            var member_work = $('#member_work').val();
            var member_qualification_id = $('#member_qualification_id').val();
            var member_relationship_id = $('#member_relationship_id').val();
            var member_id_number = $('#member_id_number').val();
            var member_date_of_birth = $('#member_date_of_birth').val();
            var member_first_name = $('#member_first_name').val();
            var member_first_name_tr = $('#member_first_name_tr').val();
            var member_family_diseases = $('#member_family_diseases').val();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: addMemberUrl,
                data: {
                    "_token": "{{ csrf_token() }}",
                    member_social_status_id: member_social_status_id,
                    member_health_status: member_health_status,
                    member_work: member_work,
                    member_relationship_id: member_relationship_id,
                    member_qualification_id: member_qualification_id,
                    member_date_of_birth: member_date_of_birth,
                    member_id_number: member_id_number,
                    member_first_name: member_first_name,
                    member_first_name_tr: member_first_name_tr,
                    member_family_diseases: member_family_diseases,
                }
            }).done(function (data) {
                if (data != 'error') {
                    $('#member_social_status_id').val('');
                    $('#member_health_status').val('');
                    $('#member_work').val('');
                    $('#member_qualification_id').val('');
                    $('#member_relationship_id').val('');
                    $('#member_id_number').val('');
                    $('#member_date_of_birth').val('');
                    $('#member_first_name').val('');
                    $('#member_first_name_tr').val('');
                    $('#member_family_diseases').val('');
                    $('#addMemberTbody').append(data.html);
                }
            });
        });
    </script>
@endsection


