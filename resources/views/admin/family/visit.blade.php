@extends('layouts.app')

@section('pageTitle','زيارات الاستمارة')

@section('content')
    @php
        $visits = $family->visits->sortByDesc('year');
        $person = $family->person;
    @endphp

    <div class="page-titles">
        <div class="d-flex align-items-center">
            <div class="custom-breadcrumb text-right">
                <a href="{{ url('/admin') }}" class="breadcrumb">الرئيسية</a>
                <a href="{{ url('/admin/families') }}" class="breadcrumb">إدارة الاستمارات والزيارات </a>
                <a href="{{ url('admin/families/visit/'.$family->id) }}" class="breadcrumb">سجل الزيارات </a>
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
                                        سجل زيارات :
                               <span style="color: red;">
                                {{ !is_null($person->full_name) ? $person->full_name : $person->first_name .' '. $person->second_name . ' ' . $person->third_name . ' '. $person->family_name }}
                            </span>
                                    </p>
                                </h5>
                                @if($visits->isEmpty())
                                    <p class="text-center"> لا توجد زيارات</p>
                                @else
                                    <div class="profiletimeline">
                                        @foreach($visits as $visit)
                                            <div class="sl-item">
                                                <div class="sl-left">
                                                    <img src="{{ asset('assets/images/users/2.jpg')}}" alt="user"
                                                         class="circle"/></div>
                                                <div class="sl-right">
                                                    <div>
                                                        <span class="sl-date" style="font-weight: bold">
                                                            تاريخ الزيارة :
                                                        </span>
                                                        @if(!is_null($visit->visit_date))
                                                            {{  $visit->visit_date }}
                                                        @else
                                                            {{  $visit->created_at }}
                                                        @endif
                                                        <br>

                                                        <span class="sl-date" style="font-weight: bold">
                                                            مدخل الزيارة :
                                                        </span>
                                                        {{ (isset($visit->user)) ? $visit->user->user_name  : ' -' }}
                                                        <br>

                                                        <span class="sl-date" style="font-weight: bold">
                                                            رقم الزيارة :
                                                        </span>
                                                        {{ $visit->year_number .' ( ' . $visit->year .' )' }}
                                                        <br>
                                                        <span class="sl-date" style="font-weight: bold">
                                                            نوع الزيارة :
                                                        </span>
                                                        {{  (isset($visit->visitReason) && (!is_null($visit->visitReason))) ? $visit->visitReason->name: 'غير مدخل'  }}
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
