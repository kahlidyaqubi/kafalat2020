@extends('layouts.app')

@section('pageTitle','تنزيل الاستمارات التركيه ')

@section('content')
    <div class="page-titles">
        <div class="d-flex align-items-center">
            <div class="custom-breadcrumb text-right">
                <a href="{{ url('/admin') }}" class="breadcrumb">الرئيسية</a>
                <a href="{{ url('/admin/families') }}" class="breadcrumb">إدارة الاستمارات والزيارات </a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m12">
                <div class="card">
                    <div class="row">
                        <div id="timeline" class="col s12">
                            <div class="card-content">
                                <h5 class="card-title">

                                </h5>
                                <div class="profiletimeline">
                                    @foreach($files as $file)
                                        @php $fileName = $file->getRelativePathname() @endphp
                                        @if (strpos($fileName, '~$') === false)
                                            <div class="sl-item">
                                                <a href="{{  asset('/word_templates_results/ytm/'.$fileName) }}">{{ $fileName }}</a>
                                            </div>
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
