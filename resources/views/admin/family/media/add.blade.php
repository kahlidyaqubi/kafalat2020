@extends('layouts.dashboard.app')

@section('pageTitle','إضافة المرفقات')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الزيارات')
@section('navigation3','إضافة المرفقات')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/families')
@section('navigation3_link','/admin/families/'.$family->id.'/addMedia')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إضافة المرفقات
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form enctype="multipart/form-data"
                      method="post"
                      action="{{ url('admin/families/addNewMedia/'.$family->id) }}">
                @csrf
                <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class=" col-lg-3 col-md-3">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">نوع المرفق</label>
                                <div style="width: 90%;">
                                    <select class="form-control" id="file_type_id" name="file_type_id[]">
                                        <option value=" " disabled selected>عنوان المرفق</option>
                                        @foreach(\App\FileType::all() as $file)
                                            <option value="{{ $file->id }}">{{ $file->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-3" id="otherFileTypeDiv">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">مرفقات أخرى</label>
                                <div style="width: 95%;">
                                    <input type="text" class="form-control" name="file_type_id_other[]"
                                           placeholder="مرفقات أخرى">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class=" col-lg-3 col-md-3">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">الملف</label>
                                <div></div>
                                <div xclass="custom-file">
                                    <input type="file" xclass="custom-file-input" name="files[]" id="customFile">
                                    <!--  <label class="custom-file-label" for="customFile">اختر الملف</label>  -->
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12" style="opacity: 0;">اضافة مرفق</label>
                                <div style="width: 95%;">
                                    <button type="button" class="btn btn-success btn-elevate btn-block "
                                            onclick="addRow()">اضافة مرفق
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                    <div id="content">

                    </div>
                    <h4>إضافة روابط</h4>
                    <div class="row">
                        <!-- Start col -->
                        <div class=" col-lg-3 col-md-3">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">نوع المرفق</label>
                                <div style="width: 90%;">
                                    <select class="form-control" id="link_file_type_id" name="link_file_type_id[]">
                                        <option value=" " disabled selected>عنوان المرفق</option>
                                        @foreach(\App\FileType::all() as $file)
                                            <option value="{{ $file->id }}">{{ $file->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-3" id="otherFileTypeDivLink">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">مرفقات أخرى</label>
                                <div style="width: 95%;">
                                    <input type="text" class="form-control" name="link_file_type_id_other[]"
                                           placeholder="مرفقات أخرى">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class=" col-lg-3 col-md-3">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">الرابط</label>

                                <div style="width: 95%;">
                                    <input type="url" class="form-control" name="links[]" id="customLink">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12" style="opacity: 0;">اضافة مرفق</label>
                                <div style="width: 95%;">
                                    <button type="button" class="btn btn-success btn-elevate btn-block "
                                            onclick="addRow2()">اضافة مرفق
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                    <div id="content2">

                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div style="width: 95%;">
                                <input type="submit" class="btn btn-success btn-elevate " value="حفظ">
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start Row -->
                    <div class="row">

                    @if($family->media->first())
                        @foreach($family->media as $media)
                            <!-- Start col -->
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <?php
                                    $extintion = pathinfo($media->path, PATHINFO_EXTENSION);
                                    ?>
                                    <div class="box-img"
                                         id="getimage[{{$media->id}}]"
                                         style="background:
                                         @if($media->type ==0)
                                                 url({{ asset('uploads/attachments/'.$media->path) }})
                                         @elseif($media->type ==2)
                                                 url({{ asset('assets/images/videoIcon.png') }})
                                         @elseif ($extintion == 'docx' ||$extintion == 'doc')
                                                 url(https://3.bp.blogspot.com/-6iWESimcpPo/WK2gZAYpV5I/AAAAAAAAD70/wj__pSD5IFwWxgyZbyS5hIkGeMNlXg1fgCLcB/s200/Microsoft%2BWord.png)
                                         @elseif ($extintion == 'zip' ||$extintion =='rar')
                                                 url(https://static.vecteezy.com/system/resources/thumbnails/000/364/266/small/File_Formats__28432_29.jpg)
                                         @elseif ($extintion == 'xlsx' ||$extintion =='xlsm'||$extintion =='xltx')
                                                 url(https://static.thenounproject.com/png/150055-200.png)
                                         @elseif ($extintion == 'pdf')
                                                 url(https://img.icons8.com/plasticine/2x/pdf-2.png)
                                         @elseif ($extintion == 'txt')
                                                 url(https://static.vecteezy.com/system/resources/thumbnails/000/362/046/small/File_Formats__28526_29.jpg)
                                         @elseif ($extintion == 'JFIF'||$extintion =='JPEG'||$extintion =='GIF'||$extintion =='BMP'||$extintion =='PNG'||$extintion =='SVG'||$extintion =='JPG'||
                                                  $extintion == 'jfif'||$extintion =='jpeg'||$extintion =='gif'||$extintion =='bmp'||$extintion =='png'||$extintion =='svg'||$extintion =='jpg')
                                                 url({{ asset('uploads/attachments/'.$media->path) }})
                                         @else
                                                 url(https://www.4me.com/wp-content/uploads/2018/01/4me-icon-attachment.png)

                                         @endif


                                                 no-repeat center center"
                                         geturl="
@if($media->type ==0)
                                         {{ asset('uploads/attachments/'.$media->path) }}
                                         @elseif($media->type ==1)
                                         {{ asset('uploads/attachments/'.$media->path) }}
                                         @elseif($media->type ==2)
                                         {{ $media->path }}
                                         @endif
                                                 ">
                                        <div class="fixed-top-rec">{{$media->fileType->name ?? '-'}}</div>
                                        <div class="overlay-box">
                                            <div class="option-icons">
                                                <a href="@if($media->type ==0)
                                                {{ asset('uploads/attachments/'.$media->path) }}
                                                @elseif($media->type ==1)
                                                {{ asset('uploads/attachments/'.$media->path) }}
                                                @elseif($media->type ==2)
                                                {{ $media->path }}
                                                @endif"
                                                   @if($extintion == 'JFIF'||$extintion =='JPEG'||$extintion =='GIF'||$extintion =='BMP'||$extintion =='PNG'||$extintion =='SVG'||$extintion =='JPG'||
                                                    $extintion == 'jfif'||$extintion =='jpeg'||$extintion =='gif'||$extintion =='bmp'||$extintion =='png'||$extintion =='svg'||$extintion =='jpg')

                                                   data-toggle="modal"
                                                   data-target="#view-img"
                                                   @endif
                                                   onclick="setimage({{$media->id}})">
                                                    <i class="fa fa-search"></i> </a>
                                                <a href="{{ url('admin/families/removeMedia/'.$media->id) }}"
                                                   class="Confirm"><i
                                                            class="fa fa-window-close"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                            @endforeach
                        @endif
                    </div>
                    <!-- End Row -->
                </form>
            </div>
        </div>
        <!--end::Portlet-->
    </div>
    @if($family->media->first())
        <div class="modal fade" id="view-img" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-img"
                             id="setimage">
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-secondary"
                               href="#" id="seturl" target="_blank">تنزيل
                            </a>
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">اغلاق
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
            <!-- Start Modal -->
            <div class="modal fade" id="delete" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-icon"><i
                                            class="flaticon-questions-circular-button"></i></div>
                                <div class="alert-text">هل انت متأكد من عملية الحذف؟</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">اغلاق
                            </button>
                            <button type="button" class="btn btn-success">نعم</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

            <!--End::Dashboard 1-->
        </div>
    @endif
    <!-- end:: Content -->
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
        $('#otherFileTypeDiv').hide();
        $("#file_type_id").change(function () {
            var id = $(this).children(":selected").attr("value");
            if ((id == 1) || (id == 6)) {
                $('#otherFileTypeDiv').show();
            } else {
                $('#otherFileTypeDiv').hide();

            }
        });
        var i = 1;

        function addRow() {
            i++;
            document.querySelector('#content').insertAdjacentHTML(
                'beforeend',
                '<div class="row" id="row' + i + '">\n' +
                '    <div class=" col-lg-3 col-md-3">\n' +
                '        <div class="form-group row">\n' +
                '            <label class="col-form-label col-lg-12">نوع المرفق</label>\n' +
                '            <div style="width: 90%;">\n' +
                '                <select class="form-control"  id="file_type_id_' + i + '"  name="file_type_id[]">\n' +
                '        <option value=" " selected>العنوان</option>' +
                '        @foreach(\App\FileType::all() as $file)' +
                '            <option value="{{ $file->id }}">{{ $file->name }}</option>' +
                '        @endforeach' +
                '                </select>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class="col-lg-3 col-md-3" id="otherFileTypeDiv_' + i + '">\n' +
                '        <div class="form-group row">\n' +
                '            <label class="col-form-label col-lg-12">مرفقات أخرى</label>\n' +
                '            <div style="width: 95%;">\n' +
                '                <input type="text" class="form-control" name="file_type_id_other[]" placeholder="مرفقات أخرى">\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class=" col-lg-3 col-md-3">\n' +
                '        <div class="form-group">\n' +
                '            <label class="col-form-label col-lg-12">الملف</label>\n' +
                '            <div></div>\n' +
                '            <div xclass="custom-file">\n' +
                '                <input type="file" name="files[]" xclass="custom-file-input" id="customFile">\n' +
                '               <!--  <label class="custom-file-label" for="customFile">اختر الملف</label>  -->\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class=" col-lg-3 col-md-3">\n' +
                '        <label class="col-form-label col-lg-12" style="opacity: 0;">حذف</label>\n' +
                '        <input type="button" class="btn btn-danger btn-elevate " value="-" onclick="removeRow(this)"/>\n' +
                '    </div>\n' +
                '\n' +
                '</div>'
            );

            showSelect(i);

            function showSelect(i) {
                // show hide file type
                $('#otherFileTypeDiv_' + i).hide();
                $("#file_type_id_" + i).change(function () {
                    var id = $(this).children(":selected").attr("value");
                    if ((id == 1) || (id == 6)) {
                        $('#otherFileTypeDiv_' + i).show();
                    } else {
                        $('#otherFileTypeDiv_' + i).hide();

                    }
                });
            }
        };

        function removeRow(input) {
            document.getElementById('content').removeChild(input.parentNode.parentNode);
        };
    </script>
    <script>
        $('#otherFileTypeDivLink').hide();
        $("#link_file_type_id").change(function () {
            var id = $(this).children(":selected").attr("value");
            if ((id == 1) || (id == 6)) {
                $('#otherFileTypeDivLink').show();
            } else {
                $('#otherFileTypeDivLink').hide();

            }
        });
        var i = 1;

        function addRow2() {
            i++;
            document.querySelector('#content2').insertAdjacentHTML(
                'beforeend',
                '<div class="row" id="row' + i + '">\n' +
                '    <div class=" col-lg-3 col-md-3">\n' +
                '        <div class="form-group row">\n' +
                '            <label class="col-form-label col-lg-12">نوع المرفق</label>\n' +
                '            <div style="width: 90%;">\n' +
                '                <select class="form-control"  id="link_file_type_id_' + i + '"  name="link_file_type_id[]">\n' +
                '        <option value=" " selected>العنوان</option>' +
                '        @foreach(\App\FileType::all() as $file)' +
                '            <option value="{{ $file->id }}">{{ $file->name }}</option>' +
                '        @endforeach' +
                '                </select>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class="col-lg-3 col-md-3" id="otherFileTypeDivLink_' + i + '">\n' +
                '        <div class="form-group row">\n' +
                '            <label class="col-form-label col-lg-12">مرفقات أخرى</label>\n' +
                '            <div style="width: 95%;">\n' +
                '                <input type="text" class="form-control" name="link_file_type_id_other[]" placeholder="مرفقات أخرى">\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class=" col-lg-3 col-md-3">\n' +
                '        <div class="form-group">\n' +
                '            <label class="col-form-label col-lg-12">الرابط</label>\n' +
                '            \n' +
                '            <div style="width: 95%;">\n' +
                '                <input type="url" name="links[]" class="form-control" >\n' +
                '                \n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class=" col-lg-3 col-md-3">\n' +
                '        <label class="col-form-label col-lg-12" style="opacity: 0;">حذف</label>\n' +
                '        <input type="button" class="btn btn-danger btn-elevate " value="-" onclick="removeRow2(this)"/>\n' +
                '    </div>\n' +
                '\n' +
                '</div>'
            );

            showSelect2(i);

            function showSelect2(i) {
                // show hide file type
                $('#otherFileTypeDivLink_' + i).hide();
                $("#link_file_type_id_" + i).change(function () {
                    var id = $(this).children(":selected").attr("value");
                    if ((id == 1) || (id == 6)) {
                        $('#otherFileTypeDivLink_' + i).show();
                    } else {
                        $('#otherFileTypeDivLink_' + i).hide();

                    }
                });
            }
        };

        function removeRow2(input) {
            document.getElementById('content2').removeChild(input.parentNode.parentNode);
        };
    </script>
    <script>
        function setimage(i) {
            console.log('test' + i);
            document.getElementById("setimage").style.cssText = document.getElementById("getimage[" + i + "]").style.cssText;
            //geturl //seturl
            document.getElementById("seturl").href = document.getElementById("getimage[" + i + "]").getAttribute('geturl');

        }
    </script>

@endsection