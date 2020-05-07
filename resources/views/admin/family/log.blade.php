@extends('layouts.app')

@section('pageTitle','سجل الاستمارة')

@section('content')
    @php
        $logs = $family->logs->sortBy('created_at');
            $person = $family->person;
    @endphp

    <div class="page-titles">
        <div class="d-flex align-items-center">
            <div class="custom-breadcrumb text-right">
                <a href="{{ url('/admin') }}" class="breadcrumb">الرئيسية</a>
                <a href="{{ url('/admin/families') }}" class="breadcrumb">إدارة الاستمارات والزيارات </a>
                <a href="{{ url('admin/families/log'.$family->id) }}" class="breadcrumb">سجل الاستمارة </a>
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
                                <p>
                                    سجل المكفول :
                                    <span style="color: red;">
                                {{ !is_null($person->full_name) ? $person->full_name : $person->first_name .' '. $person->second_name . ' ' . $person->third_name . ' '. $person->family_name }}
                            </span>
                                </p>
                            </h5>
                                <div class="profiletimeline">
                                    @foreach($logs->sortByDesc('created_at') as $log)
                                        <div class="sl-item">
                                            <div class="sl-left"><img src="{{ asset('assets/images/users/2.jpg')}}"
                                                                      alt="user" class="circle"/></div>
                                            <div class="sl-right">
                                                <span class="sl-date" style="font-weight: bold">
                                                    تاريخ العمليه :
                                                </span>
                                                @if(!is_null($log->visit_date))
                                                    {{  $log->visit_date }}
                                                @else
                                                    {{  $log->created_at }}
                                                @endif
                                                <br>

                                                <span class="sl-date" style="font-weight: bold">
                                                    المستخدم :
                                                </span>
                                                {{ (isset($log->user)) ? $log->user->user_name  : ' -' }}
                                                <br>

                                                @if(($log->visit_reason_id == 1) || ($log->visit_reason_id == 6))
                                                    <span class="sl-date" style="font-weight: bold">
                                                    رقم الزيارة :
                                                </span>
                                                    {{ $log->year_number .' ( ' . $log->year .' )' }}
                                                    <br>

                                                @endif
                                                <span class="sl-date" style="font-weight: bold">
                                                    نوع العمليه :
                                                </span>
                                                {{  (isset($log->visitReason) && (!is_null($log->visitReason))) ? $log->visitReason->name: 'غير مدخل'  }}
                                            </div>
                                        </div>
                                        <hr>
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
