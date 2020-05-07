<!DOCTYPE html>

<html lang="ar" direction="rtl" dir="rtl" style="direction: rtl">

<!-- begin::Head -->
<head>
    <base href="">
    <meta charset="utf-8"/>
    <title> @yield('pageTitle','') |
        كفالات</title>
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="userId" content="{{ Auth::check() ? Auth::user()->id : '' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('new_theme/assets/plugins/general/socicon/css/socicon.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('new_theme/assets/plugins/general/plugins/line-awesome/css/line-awesome.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('new_theme/assets/plugins/general/plugins/flaticon/flaticon.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('new_theme/assets/plugins/general/plugins/flaticon2/flaticon.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('new_theme/assets/plugins/general/@fortawesome/fontawesome-free/css/all.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-select/dist/css/bootstrap-select.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('new_theme/assets/plugins/general/select2/dist/css/select2.css')}}" rel="stylesheet"
          type="text/css"/>


    <!--end:: Vendor Plugins -->
    <link href="{{asset('new_theme/assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{asset('new_theme/assets/css/skins/header/base/dark.rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('new_theme/assets/css/skins/header/menu/dark.rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('new_theme/assets/css/skins/brand/dark.rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('new_theme/assets/css/skins/aside/dark.rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{asset('new_theme/assets/media/logo-icon.png')}}"/>
    <style media="screen">
        .table th, .table td {
            vertical-align: inherit;
        }

        .select2 {
            width: 100% !important
        }

        @media (max-width: 781px) {
            .kt-badge.kt-badge--danger,
            .kt-badge.kt-badge--success {
                background-color: transparent;
                color: #000
            }

            .kt-widget17__items {
                flex-direction: column;
            }
        }

        #table_length {
            display: none;
        }

        /*الهوامش العلوية والسفلية*/
        .kt-content {
            padding: 20px 0 0;
        }

        /*الهوامش الخارجية السفلية للحقول اضافة الاتصال*/
        .form-group {
            margin-bottom: 1rem;
        }

        .kt-portlet .kt-portlet__body {
            padding: 10px 25px;
        }
        .dropdown-menu{
    /*transform: translate3d(32px, 35px, 0px)!important;*/
        transform: translate3d(32px, 20px, 0px)!important;

    
}

    </style>
    @yield('headerCSS')
    <link href="{{asset('new_theme/assets/css/new-style.css')}}" rel="stylesheet" type="text/css"/>

    @yield('headerJS')
</head>

<!-- end::Head -->


<!-- begin::Body -->

<body
        class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
<!-- begin:: Page -->
<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="index.html">
            <img alt="Logo" src="{{asset('new_theme/assets/media/logo-light-icon.png')}}" width="30" height="30"/>
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left"
                id="kt_aside_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                    class="flaticon-more"></i></button>
    </div>
</div>
<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <!-- begin:: Aside bar -->
        <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop"
             id="kt_aside">
            <!-- begin:: Aside side bar title panel -->
        @include('layouts.dashboard.sidebar')
        <!-- end:: Aside -->

            <!-- begin:: Aside Menu -->
        @include('layouts.dashboard.aside_menu')
        <!-- end:: Aside Menu -->
        </div>
        <!-- end:: Aside -->

        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
                <!-- begin:: Header Menu -->
                <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                    <div id="kt_header_menu"
                         class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default"></div>
                </div>
                <!-- end:: Header Menu -->
                <!-- begin:: Header Topbar -->
            @include('layouts.dashboard.topbar')
            <!-- end:: Header Topbar -->
            </div>
            <!-- end:: Header -->
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                <!-- begin:: Content Head -->
                <div class="kt-subheader  kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
                            @if (trim($__env->yieldContent('navigation1')))
                                <a href="@yield('navigation1_link')"><h3
                                            class="kt-subheader__title">@yield('navigation1')</h3></a>
                                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            @endif
                            @if (trim($__env->yieldContent('navigation2')))
                                <a href="@yield('navigation2_link')"><span
                                            class="kt-subheader__title">@yield('navigation2')</span>
                                </a><span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            @endif
                            @if (trim($__env->yieldContent('navigation3')))
                                <a href="@yield('navigation3_link')"> <span
                                            class="kt-subheader__desc">@yield('navigation3')</span>
                                </a> <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- end:: Content Head -->

                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <!--Begin::Row-->
                    @include('layouts.dashboard.message')
                    <div class="row">
                        @yield('content')
                    </div>

                    <!--End::Row-->


                    <!--End::Dashboard 1-->
                </div>

                <!-- end:: Content -->
            </div>

            <!-- begin:: Footer -->
        @include('layouts.dashboard.footer')
        <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- end::Scrolltop -->
<!-- Start Loader -->
<div class="box-loader">

    <div class="lds-roller">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- End Loader -->
<!-- Start Tool Box -->
<!--<section class="option-box">-->
<!--    <div class="color-option">-->
<!--        <ul class="list-unstyled">-->
<!--            <li></li>-->
<!--            <li></li>-->
<!--            <li></li>-->
<!--            <li></li>-->
<!--            <li></li>-->
<!--        </ul>-->
<!--    </div>-->
<!--    <i class="fa fa-cog fa-2x gear-check"></i>-->
<!--</section>-->
<!-- End Tool Box -->


<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<!--begin:: Vendor Plugins -->
<script src="{{asset('new_theme/assets/plugins/general/jquery/dist/jquery.js')}}" type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/popper.js/dist/umd/popper.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/js-cookie/src/js.cookie.js')}}" type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/moment/min/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/tooltip.js/dist/umd/tooltip.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/perfect-scrollbar/dist/perfect-scrollbar.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/sticky-js/dist/sticky.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/jquery-form/dist/jquery.form.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/block-ui/jquery.blockUI.js')}}" type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/js/global/integration/plugins/bootstrap-datepicker.init.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/bootstrap-select/dist/js/bootstrap-select.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/bootstrap-switch/dist/js/bootstrap-switch.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/js/global/integration/plugins/bootstrap-switch.init.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/select2/dist/js/select2.full.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/handlebars/dist/handlebars.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/js/global/integration/plugins/jquery-validation.init.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/toastr/build/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/morris.js/morris.js')}}" type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/sweetalert2/dist/sweetalert2.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/js/global/integration/plugins/sweetalert2.init.js')}}"
        type="text/javascript"></script>
<script src="{{asset('new_theme/assets/plugins/general/chart.js/dist/Chart.bundle.js')}}"
        type="text/javascript"></script>

<!--end:: Vendor Plugins -->
<script src="{{asset('new_theme/assets/js/scripts.bundle.js')}}" type="text/javascript"></script>
<!-- Start Custom Select 2 Selector -->
<script>
    $('.select2-multi').select2({
        placeholder: "اختر من القائمة"
    });
</script>

@yield('select2')

<!-- End Custom Select 2 Selector -->
<script>
    $(document).ready(function () {

        $("#q").on('keypress', function (e) {
            if (e.which == 13) {
                console.log('dodo elgabas');
                $('#search').submit();
            }
        });
    });

</script>
<!--begin::Page Scripts(used by this page) -->
<script src="{{asset('new_theme/assets/js/pages/dashboard.js')}}" type="text/javascript"></script>
<script src="{{asset('new_theme/assets/js/myjs.js')}}" type="text/javascript"></script>
<script src="{{  asset('js/app.js') }}"></script>

<script>
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    var userId = $('meta[name="userId"]').attr('content');
    console.log('App.User.' + userId);
    Echo.private('App.User.' + userId).notification((notification) => {
        console.log('test2020');
        var action = notification.data.action;
        var the_id = notification.id;
        console.log(action);
        var a = document.createElement("a");
        a.setAttribute("href", action.link);
        a.setAttribute("onclick", 'pop(this)');
        a.setAttribute("the_id", the_id);
        a.setAttribute("the_href", action.link);
        a.innerHTML = "  <a  class=\"kt-notification__item\"\n" +
            "                                <div class=\"kt-notification__item-icon\">\n" +
            "                                    " + action.type + "\n" +
            "                                </div>\n" +
            "                                <div class=\"kt-notification__item-details\">\n" +
            "                                    <div class=\"kt-notification__item-title\">\n" +
            "                                        " + action.title + "\n" +
            "                                    </div>\n" +
            "                                    <div class=\"kt-notification__item-time\">\n" +
            "                                        " + formatDate(action.created_at) + "\n" +
            "                                    </div>\n" +
            "                                </div>\n" +
            "                            </a>";
        document.getElementById("notif").prepend(a);
        var num_notif = document.querySelectorAll(".num_notif");
        var num_notif_count = 1 + parseInt(document.querySelector(".num_notif").innerText);
        for (i = 0; i < num_notif.length; i++) {
            num_notif[i].innerHTML = "<span>" + num_notif_count + "</span>";
        }
        var audio = new Audio('{{asset('audio/unsure.mp3')}}');
        audio.play();
    });


</script>
<script>
    window.onload = function () {
        document.getElementById('massage').onkeyup = function () {
            if (this.value.length >= 75) {
                this.style.color = "red";

            }else{
                this.style.color="#000";
            }
            document.getElementById('count_msg').innerText = 75 - this.value.length;
        }

    }
</script>
<script>

    function pop(e) {
        event.preventDefault();
        $(this).addClass("kt-notification__item--read");
        var the_id = e.getAttribute('the_id');
        var the_href = e.getAttribute('the_href');
        console.log(the_href);
        $.get('/admin/getnotfiy/' + the_id, function (data, status) {
        });
        console.log('test');
        location.href = the_href;
    };

</script>
<script>


    $(function () {
        //$("#Confirm").modal("show");
        $(".Confirm").click(function () {
            $("#kt_modal_1").modal("show");
            $("#kt_modal_1 .btn-danger").attr("href", $(this).attr("href"));
            return false;
        });
    });
</script>
@yield('footerCSS')
@yield('footerJS')
<script>
    $(document).ready(function () {


$('.table-responsive').on('show.bs.dropdown', function () {
     $('.table-responsive').css( "overflow", "inherit" );
});

$('.table-responsive').on('hide.bs.dropdown', function () {
     $('.table-responsive').css( "overflow", "auto" );
})

        $('ul.pagination').css({"margin": "auto"});

        function arabicInput(event) {
            var value = String.fromCharCode(event.which);
            var pattern = new RegExp(/^[\u0621-\u064A\u0660-\u0669 ]+$/i);
            return pattern.test(value);
        }

        function turkeyInput(event) {
            var value = String.fromCharCode(event.which);
            var pattern = new RegExp(/[a-zåäöığüşöçĞÜŞÖÇİ ]/i);
            return pattern.test(value);
        }

        $('.arabic').bind('keypress', arabicInput);
        $('.turkey').bind('keypress', turkeyInput);
        $(".numbers").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 1632 || e.which > 1641)) {
                return false;
            }
        });
        for(i=0;i<document.querySelectorAll('[data-toggle="dropdown"]').length;i++){
document.querySelectorAll('[data-toggle="dropdown"]')[i].click();
$(window).scrollTop(0);
}

var aTags = document.getElementsByTagName("td");
var searchText = "$";
var found;

for (var i = 0; i < aTags.length; i++) {
  if (aTags[i].textContent.includes(searchText)) {
    found = aTags[i];
    aTags[i].style.fontFamily="Aril,serif";
  }
}

var aTags = document.getElementsByTagName("th");
var searchText = "#";
var found;

for (var i = 0; i < aTags.length; i++) {
  if (aTags[i].textContent.includes(searchText)) {
    found = aTags[i];
    aTags[i].style.fontFamily="Aril,serif";
  }
}
  
    });
</script>
<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
