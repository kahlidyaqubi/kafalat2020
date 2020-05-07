@extends('layouts.app')

@section('pageTitle','لوحة التحكم')

@section('headerCSS')

    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/dashboard1.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Sales Summery -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col l3 m6 s12">
                <div class="card danger-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">0</h2>
                                <h6 class="white-text op-5 light-blue-text">عدد الأيتام</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">assignment</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l3 m6 s12">
                <div class="card info-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">0</h2>
                                <h6 class="white-text op-5">عدد الزيارات</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">receipt</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col l3 m6 s12">
                <div class="card success-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">0</h2>
                                <h6 class="white-text op-5 text-darken-2">عدد المساعدات الموسمية</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">equalizer</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col l3 m6 s12">
                <div class="card warning-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">0</h2>
                                <h6 class="white-text op-5">عدد المساعدات الطارئة</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">attach_money</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col l3 m6 s12">
                <div class="card danger-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">0</h2>
                                <h6 class="white-text op-5 light-blue-text">عدد المستخدمين</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">assignment</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l3 m6 s12">
                <div class="card info-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">0</h2>
                                <h6 class="white-text op-5">عدد الاتصالات</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">receipt</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col l3 m6 s12">
                <div class="card success-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">0</h2>
                                <h6 class="white-text op-5 text-darken-2">عدد الصرفيات</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">equalizer</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col l3 m6 s12">
                <div class="card warning-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">0</h2>
                                <h6 class="white-text op-5">عدد الكفلاء </h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">attach_money</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Sales Summery -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col s6">
                <div class="card">
                    <div class="card-content">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="card-title">الاستمارات</h5>
                            </div>
                            <div class="ml-auto">
                                <ul class="list-inline font-12 dl m-r-10">
                                    <li class="cyan-text"><i class="fa fa-circle"></i> الزيارات</li>
                                    <li class="blue-text text-accent-4"><i class="fa fa-circle"></i> الأيتام</li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sales Summery -->
                        <div class="p-t-20">
                            <div class="row">
                                <div class="col s12">
                                    <div id="chartA" style="height: 332px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="card">
                    <div class="card-content">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="card-title">الصرفيات</h5>
                            </div>
                        </div>
                        <!-- Sales Summery -->
                        <div class="p-t-20">
                            <div class="row">
                                <div class="col s12">
                                    <div id="chartB" style="height: 332px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('footerPlugins')
    <script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('js/pages/dashboards/dashboard1.js') }}"></script>
@endsection
