@extends('layouts.dashboard.app')

@section('pageTitle','لا يمكن الوصول')
@section('headerCSS')@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','لا يمكن الوصول')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/noAccess')
@section('content')
    <div class="col-lg-12 col-xl-12 ">
        <!--begin:: Widgets/Activity-->
        <div class="alert alert-danger">عذرا لا تملك صلاحية على الرابط المطلوب</div>
    </div>
@endsection

@section('footerJS')

@endsection