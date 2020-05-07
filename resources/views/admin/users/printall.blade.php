<html dir="rtl">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<div>
    <div>
        <div>
            <div>
                <h5>عرض المستخدمين</h5>
                <table border="1" style="border: 1px black solid">
                    <thead>
                    <tr>
                        @if(collect($coulmn)->contains('id'))
                            <th>
                                #
                            </th>@endif
                        @if(collect($coulmn)->contains('image'))
                            <th
                            >الصوره
                            </th>@endif
                        @if(collect($coulmn)->contains('full_name'))
                            <th>الاسم رباعي
                            </th>@endif
                        @if(collect($coulmn)->contains('id_number'))
                            <th>رقم الهوية
                            </th>@endif
                        @if(collect($coulmn)->contains('email'))
                            <th aria-sort="ascending">البريد الإلكتروني
                            </th>@endif
                        @if(collect($coulmn)->contains('address'))
                            <th>العنوان
                            </th>@endif
                        @if(collect($coulmn)->contains('mobile_one'))
                            <th>جوال1
                            </th>@endif
                        @if(collect($coulmn)->contains('mobile_two'))
                            <th>جوال2
                            </th>@endif
                        @if(collect($coulmn)->contains('mobile'))
                            <th>هاتف أرض
                            </th>@endif
                        @if(collect($coulmn)->contains('work_start_date'))
                            <th>تاريخ بدء العمل
                            </th>@endif
                        @if(collect($coulmn)->contains('departmen'))
                            <th>القسم
                            </th>@endif
                        @if(collect($coulmn)->contains('social_status'))
                            <th>الحالة الاجتماعية
                            </th>@endif
                        @if(collect($coulmn)->contains('university_specialty'))
                            <th>التخصص الجامعي
                            </th>@endif
                        @if(collect($coulmn)->contains('date_of_birth'))
                            <th>تاريخ الميلاد
                            </th>@endif
                        @if(collect($coulmn)->contains('suspend'))
                            <th>ايقاف
                            </th>@endif
                        @if(collect($coulmn)->contains('operations'))
                            <th>العمليات
                            </th>@endif

                    </tr>

                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>

                            @if(collect($coulmn)->contains('id'))
                                <td>{{ $item->id }}</td>@endif
                            @if(collect($coulmn)->contains('image'))
                                <td>
                                    @if(((!is_null($item->image)) && (!is_null($item->image)) && (($item->image != ''))))
                                        <img height="30" width="30" alt="user"
                                             src="{{ public_path($item->image) }}">

                                    @else
                                        <img height="30" width="30" src="{{public_path('/assets/images/users/2.jpg')}}"
                                             alt="user"
                                             class="circle profile-pic">
                                    @endif
                                </td>@endif
                            @if(collect($coulmn)->contains('full_name'))
                                <td>{{$item->full_name}}</td>@endif
                            @if(collect($coulmn)->contains('id_number'))
                                <td>{{$item->id_number}}</td>@endif
                            @if(collect($coulmn)->contains('email'))
                                <td>{{$item->email}}</td>@endif
                            @if(collect($coulmn)->contains('address'))
                                <td>@if($item->neighborhood){{$item->neighborhood->name ?? ""}}
                                    /{{$item->neighborhood->city->name ?? ""}}
                                    / {{$item->neighborhood->city->governorate->name ?? ""}}
                                    / @endif {{$item->address}}</td>@endif
                            @if(collect($coulmn)->contains('mobile_one'))
                                <td>{{$item->mobile_one}}</td>@endif
                            @if(collect($coulmn)->contains('mobile_two'))
                                <td>{{$item->mobile_two}}</td>@endif
                            @if(collect($coulmn)->contains('mobile'))
                                <td>{{$item->mobile}}</td>@endif
                            @if(collect($coulmn)->contains('work_start_date'))
                                <td>{{$item->work_start_date?date('d-m-Y', strtotime($item->work_start_date)):""}}</td>@endif
                            @if(collect($coulmn)->contains('departmen'))
                                <td>@if($item->department){{$item->department->name}}@endif</td>@endif
                            @if(collect($coulmn)->contains('university_specialty'))
                                <td>@if($item->university_specialty){{$item->university_specialty->name}}@endif</td>@endif
                            @if(collect($coulmn)->contains('social_status'))
                                <td>@if($item->social_status){{$item->social_status->name}}@endif</td>@endif
                            @if(collect($coulmn)->contains('date_of_birth'))
                                <td>{{$item->date_of_birth?date('d-m-Y', strtotime($item->date_of_birth)):""}}</td>@endif
                            @if(collect($coulmn)->contains('suspend'))
                                <td>
                                    <p>
                                        <label class="m-l-15">
                                            <input type="checkbox" @if(auth()->user()->hasPermissionTo(6))
                                            {{$item->getAllPermissions()->first()?"":"checked disabled title='المستخدم_موقف' "}} value="{{$item->id}}"
                                                   @else
                                                   {{$item->getAllPermissions()->first()?"":"checked "}}disabled
                                                   title="لا تملك صلاحية ايقاف مستخدم" value="{{$item->id}}"
                                                    @endif>
                                        </label>
                                    </p>
                                </td>@endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
</body>
<style type="text/css">
    *, body, table, th, tr, td, tbody {
        font-family: 'examplefont', sans-serif;
        text-align: right;
        color: #000;

    }
</style>
</html>

