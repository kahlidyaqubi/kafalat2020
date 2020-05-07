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
                            <th >
                                #
                            </th>@endif
                        @if(collect($coulmn)->contains('family_or_institution'))
                            <th > المستلم
                            </th>@endif
                        @if(collect($coulmn)->contains('coupon_type'))
                            <th >نوع المستلم
                            </th>@endif
                        @if(collect($coulmn)->contains('his_date'))
                            <th >تاريخ المساعدة
                            </th>@endif
                        @if(collect($coulmn)->contains('sponsor'))
                            <th >الكافل
                            </th>@endif
                        @if(collect($coulmn)->contains('count'))
                            <th >المقدار
                            </th>@endif
                        @if(collect($coulmn)->contains('amount'))
                            <th >المبلغ
                            </th>@endif
                        @if(collect($coulmn)->contains('delivery_status'))
                            <th >التسليم
                            </th>@endif
                        @if(collect($coulmn)->contains('admin_status'))
                            <th >رأي الإدارة
                            </th>@endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($urgent_coupons as $item)
                        <tr >
                            @if(collect($coulmn)->contains('id'))
                                <td>{{ $item->id }}</td>@endif
                            @if(collect($coulmn)->contains('family_or_institution'))
                                <td>
                                    {{$item->family_id && $item->family ? $item->family->person->full_name : ($item->institution?$item->institution->name:"-")}}</td>@endif
                            @if(collect($coulmn)->contains('coupon_type'))
                                <td>{{$item->family_id? "للأفراد" : "للمؤسسات"}}</td>@endif
                            @if(collect($coulmn)->contains('his_date'))
                                <td>{{$item->his_date?date('d-m-Y', strtotime($item->his_date)):""}}</td>@endif
                            @if(collect($coulmn)->contains('sponsor'))
                                <td>{{$item->sponsor?$item->sponsor->name:""}}</td>@endif
                            <?php
                            $count = "";
                            $z = 0;
                            foreach ($item->coupon_item_types as $coupon_item_types) {
                                if ($z > 0)
                                    $count = $count . " و";

                                $count = $count . "" . $coupon_item_types->number . " " . $coupon_item_types->item_type?$coupon_item_types->item_type->name:"-" . "-" . $coupon_item_types->item_type->item_category?$coupon_item_types->item_type->item_category->name:"-" . "";
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


