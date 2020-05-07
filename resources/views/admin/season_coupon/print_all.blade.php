<html dir="rtl">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<div>
    <div>
        <div>
            <div>
                <h5>عرض المساعدات الموسمية</h5>
                <table>
                    <thead>
                    <tr>

                        @if(collect($coulmn)->contains('id'))
                            <th>
                                #
                            </th>@endif
                        @if(collect($coulmn)->contains('family_or_institution'))
                            <th> المستلم
                            </th>@endif
                        @if(collect($coulmn)->contains('coupon_type'))
                            <th>نوع المستلم
                            </th>@endif
                        @if(collect($coulmn)->contains('execution_date'))
                            <th>تاريخ التنفيذ
                            </th>@endif
                        @if(collect($coulmn)->contains('delivery_date'))
                            <th>تاريخ التسليم
                            </th>@endif
                        @if(collect($coulmn)->contains('application_date'))
                            <th>تاريخ الطلب
                            </th>@endif

                        @if(collect($coulmn)->contains('count'))
                            <th>المقدار
                            </th>@endif
                        @if(collect($coulmn)->contains('amount'))
                            <th>المبلغ
                            </th>@endif
                        @if(collect($coulmn)->contains('delivery_status'))
                            <th>التسليم
                            </th>@endif
                        @if(collect($coulmn)->contains('admin_status'))
                            <th>رأي الإدارة
                            </th>@endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($season_coupons as $item)
                        <tr>
                            @if(collect($coulmn)->contains('id'))
                                <td>{{ $item->id }}</td>@endif
                            @if(collect($coulmn)->contains('family_or_institution'))
                                <td>{{$item->family_id? $item->family->person->full_name : $item->institution->name}}</td>@endif
                            @if(collect($coulmn)->contains('coupon_type'))
                                <td>{{$item->family_id? "للأفراد" : "للمؤسسات"}}</td>@endif
                            @if(collect($coulmn)->contains('execution_date'))
                                <td>{{$item->execution_date?date('d-m-Y', strtotime($item->execution_date)):""}}</td>@endif
                            @if(collect($coulmn)->contains('delivery_date'))
                                <td>{{$item->delivery_date?date('d-m-Y', strtotime($item->delivery_date)):""}}</td>@endif
                            @if(collect($coulmn)->contains('application_date'))
                                <td>{{$item->application_date?date('d-m-Y', strtotime($item->application_date)):""}}</td>@endif
                            <?php
                            $count = "";
                            $z = 0;
                            foreach ($item->coupon_item_types as $coupon_item_types) {
                                if ($z > 0)
                                    $count = $count . " و";

                                $count = $count . "" . $coupon_item_types->number . " " . $coupon_item_types->item_type->name . "-" . $coupon_item_types->item_type->item_category->name . "";
                                $z++;
                            }
                            if ($item->amount_currency)
                                $amount = $item->amount . "" . $item->amount_currency->icon;
                            else
                                $amount = " ";
                            ?>
                            @if(collect($coulmn)->contains('count'))
                                <td>{{$count}}</td>@endif
                            @if(collect($coulmn)->contains('amount'))
                                <td>{{$amount}}</td>@endif
                            @if(collect($coulmn)->contains('delivery_status'))
                                <td>
                                    {{$item->delivery_status? 'نعم' : 'لا'}}
                                </td>@endif
                            @if(collect($coulmn)->contains('admin_status'))
                                <td>
                                    {{$item->admin_status?$item->admin_status->name:"-"}}
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


