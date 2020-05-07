<!DOCTYPE html>
<html lang="en" dir="rtl">
<meta charset="utf-8"/>


<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">

<!-- Each sheet element should have the class "sheet" -->
<!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
<article>
    <section class="sheet padding-5mm" style="color: red;">
        @if($theaction == 'print')
            <table class="table" style="width: 100%;margin-top:0;padding-top:0">
                <tr>
                    <td>
                        <header>
                            <table style="width: 100%">
                                <?php

                                $months_ar = implode(" -", $expense_details->first()->months->pluck('name_ar')->toArray()) . "-" . $expense_details->first()->expense->year;
                                $months_en = implode(" -", $expense_details->first()->months->pluck('name_en')->toArray()) . " " . $expense_details->first()->expense->year;
                                $months_tr = implode(" VE ", $expense_details->first()->months->pluck('name_tr')->toArray()) . "/" . $expense_details->first()->expense->year;
                                $recive_date_ytm = date('Y/m/d', strtotime($expense_details->first()->expense->recive_date));
                                $recive_date_family = date('d.m.y', strtotime($expense_details->first()->expense->recive_date));
                                $funded_institution_name = $expense_details->first()->funded_institution->name_tr;
                                if (count($expense_details->pluck('funded_institution_id')->toArray()) == 1)
                                    $logo = $expense_details->first()->funded_institution->logo;
                                else
                                    $logo = null;

                                ?>
                                @if($thetype=='ytm')
                                    <tr>
                                        <td class="right" style="width: 13%;text-align:center;">
                                            <img src="{{public_path('print_pages/images/logo.jpg')}}" width="75%">
                                        </td>
                                        <td class="center align-center">
                                            <h1>YARDEMELI INTERNATIONAL HUMANITARIAN AID FOUNDATION</h1>
                                            <h1>ORPHAN EDUCATION PROJECT-THE CASH DISTRIBUTION LIST</h1>
                                            <h2>COUNTRY_PALESINE PARTNER AGENCY YARDIMEL GAZA OFFICE</h2>
                                            <h2>AID PERIOD: {{$months_en}} </h2>
                                            <hr class="thick"/>
                                            <h2 class="ar-text">مشروع تعليم الأيتام - قائمة دفعة{{$months_ar}} - مقدمة
                                                من جمعية ياردم الي التركية بتارخ {{$recive_date_ytm}}</h2>
                                        </td>

                                        <td class="right" style="width: 13%;text-align:center;">
                                            <img src="{{public_path('print_pages/images/logo.jpg')}}" width="75%">
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="right" style="width: 13%;text-align:center;">
                                            <img
                                                    @if(($logo) && file_exists(public_path() . "" . $logo))
                                                    src="{{public_path($item->img)}}"
                                                    @else
                                                    src="{{public_path('print_pages/images/logo.jpg')}}"
                                                    @endif
                                                    width="75%">
                                        </td>
                                        <td class="center align-center">
                                            <h1>YARDEMELI</h1>
                                            <h1> ULUSLAR ARASI INSANI YARDIM DERNEGL</h1>
                                            <h2>YARDIM DONEML: {{$months_tr}} - YARDIM GONDERL TARIHI
                                                :{{$recive_date_family}} </h2>
                                            <h2>DAGITIM YAPAN KURUM: YARDIMELI DERNEGI - GAZZE OFISI /FILISTIN</h2>
                                            <h2>KSRDES AILE GRUBU : {{$funded_institution_name}} </h2>
                                            <hr class="thick"/>
                                            <h2 class="ar-text">مشروع عائلة الأخوة - قائمة دفعة{{$months_ar}} - مقدمة
                                                من جمعية ياردم الي التركية بتارخ {{$recive_date_ytm}}</h2>
                                        </td>

                                        <td class="right" style="width: 13%;text-align:center;">
                                            <img src="{{public_path('print_pages/images/logo.jpg')}}" width="75%">
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </header>
                        <hr class="thin margin-bottom-15"/>
                    </td>
                </tr>
            </table>
        @endif
        <table cellspacing="0" class="margin-bottom-5" style="width: 100%" border="1" style="font-weight: bold">
            <tr class="align-center head-tr">
                <td>
                    @if($thetype=='ytm')
                        التوقيع
                    @else
                        امضاء المستلم
                    @endif
                </td>
                @if($thetype!='ytm')
                    <td>
                        الشهر
                    </td>
                @endif
                @if($thetype=='ytm')
                    <td>
                        رقم الهوية
                        <br>
                        ولي الامر
                    </td>
                    <td>
                        اسم ولي الأمر
                    </td>
                @endif

                <td width="5%">
                    مقدار المساعدة
                </td>
                @if($thetype=='ytm')
                    <td>
                        الشهر
                    </td>
                @else
                    <td width="15%">
                        اسم الكافل
                    </td>
                    @if($thetype=='unv')
                        <td>
                            الرقم الجامعي
                        </td>
                    @endif
                    <td width="10%">
                        رقم الهوية
                    </td>
                @endif
                <td width="15%">
                    @if($thetype=='ytm')
                        اسم اليتيم
                    @else
                        اسم المكفول
                    @endif
                </td>
                <td width="20%">
                    @if($thetype=='ytm')
                        اسم اليتيم
                    @else
                        اسم المكفول
                    @endif
                </td>
                <td width="15%">
                    الكود
                </td>
                <td>
                    رقم
                </td>
            </tr>
            <tr class="align-center head-tr">
                <td>
                    @if($thetype=='ytm')
                        SIGNATURE
                    @else
                        T.A Imzasi
                    @endif


                </td>
                @if($thetype!='ytm')
                    <td>
                        DÖNEM
                    </td>
                @endif
                @if($thetype=='ytm')
                    <td>
                        ID NO.
                    </td>
                    <td>
                        GUARDIAN NAME
                    </td>
                @endif
                <td>
                    @if($thetype=='ytm')
                        AMOUNT OF MONEY
                    @else
                        Yardim Miktari
                    @endif
                </td>
                @if($thetype=='ytm')
                    <td>
                        MONTHS
                    </td>
                @else
                    <td>
                        Veren El
                    </td>
                    @if($thetype=='unv')
                        <td>
                            OKUL NO.
                        </td>
                    @endif
                    <td>
                        Kimlik NO.
                    </td>
                @endif
                <td>
                    @if($thetype=='ytm')
                        ORPHAN NAME
                    @else
                        Alan El
                    @endif
                </td>
                <td>
                    @if($thetype=='ytm')
                        ORPHAN NAME
                    @else
                        Alan El
                    @endif
                </td>
                <td>
                    @if($thetype=='ytm')
                        CODE
                    @else
                        Kod
                    @endif
                </td>
                <td>
                    SIRA
                </td>
            </tr>
            <?php $i = 1;
            $j= 1;?>
            @foreach($expense_details->chunk(31) as $expense_detailss)
            
            @foreach($expense_detailss as $expense_detail)
                <tr class="align-center">
                    <td></td>
                    @if($thetype!='ytm')
                        <td>
                            @foreach($expense_detail->months as $month)
                                {{$month->name_tr}}/{{$month->name_ar}}
                                <br>
                            @endforeach
                        </td>
                    @endif
                    @if($thetype=='ytm')
                        <td>
                            {{$expense_detail->family->representative?$expense_detail->family->representative->id_number:"-"}}
                        </td>
                        <td>
                            {{$expense_detail->family->representative?$expense_detail->family->representative->full_name:"-"}}
                        </td>
                    @endif
                    <td>
                        @if($thetype=='normal')
                            ₪  {{$expense_detail->amount}}
                        @else
                            {{$expense_detail->currency->icon}}  {{$expense_detail->amount_befor}}
                        @endif
                    </td>
                    @if($thetype=='ytm')
                        <td>
                            @foreach($expense_detail->months as $month)
                                {{$month->name_tr}}/{{$month->name_ar}}
                                <br>
                            @endforeach
                        </td>
                    @else
                        <td>
                            @foreach($expense_detail->sponsors as  $sponsor)
                                {{$sponsor->name}}
                                <br>
                            @endforeach
                        </td>
                        @if($thetype=='unv')
                            <td>
                                {{$expense_detail->family->id_university}}
                            </td>
                        @endif
                        <td>
                            {{$expense_detail->family->person->id_number}}
                        </td>

                    @endif
                    <td>
                        {{$expense_detail->family->person->full_name}}
                    </td>
                    <td>
                        {{$expense_detail->family->person->full_name_tr}}
                    </td>
                    <td>
                        {{$expense_detail->family->code}}
                    </td>
                    <td>
                        {{$i}}
                    </td>
                </tr>
                <?php $i++; ?>

            @endforeach
            @if($j==ceil($expense_details->count()/31))
             <tr>
                <td
                        @if($thetype=='unv')
                        colspan="2"
                        @elseif($thetype=='ytm')
                        colspan="3"
                        @else
                        colspan="2"
                        @endif
                ></td>

                <td>
                    @if($thetype=='normal')
                        ₪
                        {{array_sum($expense_details->pluck('amount')->toArray())}}
                    @else
                        {{$expense_details->first()->currency->icon}}
                        {{array_sum($expense_details->pluck('amount_befor')->toArray())}}
                    @endif
                </td>
                <td
                        @if($thetype=='unv')
                        colspan="8"
                        @elseif($thetype=='ytm')
                        colspan="5"
                        @else
                        colspan="7"
                        @endif
                >total</td>
            </tr>
            @endif
             </table>
        <table style="width: 100%;margin-top: 40px;">
            <tr>
                <th class="right align-right" style="width: 30%;">
                    التوقيع: _____________________
                </th>
                <td class="center align-center">
                    page  {{$j}} of {{ceil($expense_details->count()/31)}} 
                </td>

                <th class="left align-left" style="width: 30%;">
                    ( الختم )
                </th>
            </tr>
             
        </table>
        <br><br>
         <?php $j++?>
            @if($j>1)
            <br><br><br><br>
            @endif
            
        <table cellspacing="0" class="margin-bottom-5" style="width: 100%" border="1" style="font-weight: bold">
              <tr class="align-center head-tr">
                <td>
                    @if($thetype=='ytm')
                        التوقيع
                    @else
                        امضاء المستلم
                    @endif
                </td>
                @if($thetype!='ytm')
                    <td>
                        الشهر
                    </td>
                @endif
                @if($thetype=='ytm')
                    <td>
                        رقم الهوية
                        <br>
                        ولي الامر
                    </td>
                    <td>
                        اسم ولي الأمر
                    </td>
                @endif

                <td width="5%">
                    مقدار المساعدة
                </td>
                @if($thetype=='ytm')
                    <td>
                        الشهر
                    </td>
                @else
                    <td width="15%">
                        اسم الكافل
                    </td>
                    @if($thetype=='unv')
                        <td>
                            الرقم الجامعي
                        </td>
                    @endif
                    <td width="10%">
                        رقم الهوية
                    </td>
                @endif
                <td width="15%">
                    @if($thetype=='ytm')
                        اسم اليتيم
                    @else
                        اسم المكفول
                    @endif
                </td>
                <td width="20%">
                    @if($thetype=='ytm')
                        اسم اليتيم
                    @else
                        اسم المكفول
                    @endif
                </td>
                <td width="15%">
                    الكود
                </td>
                <td>
                    رقم
                </td>
            </tr>
            <tr class="align-center head-tr">
                <td>
                    @if($thetype=='ytm')
                        SIGNATURE
                    @else
                        T.A Imzasi
                    @endif


                </td>
                @if($thetype!='ytm')
                    <td>
                        DÖNEM
                    </td>
                @endif
                @if($thetype=='ytm')
                    <td>
                        ID NO.
                    </td>
                    <td>
                        GUARDIAN NAME
                    </td>
                @endif
                <td>
                    @if($thetype=='ytm')
                        AMOUNT OF MONEY
                    @else
                        Yardim Miktari
                    @endif
                </td>
                @if($thetype=='ytm')
                    <td>
                        MONTHS
                    </td>
                @else
                    <td>
                        Veren El
                    </td>
                    @if($thetype=='unv')
                        <td>
                            OKUL NO.
                        </td>
                    @endif
                    <td>
                        Kimlik NO.
                    </td>
                @endif
                <td>
                    @if($thetype=='ytm')
                        ORPHAN NAME
                    @else
                        Alan El
                    @endif
                </td>
                <td>
                    @if($thetype=='ytm')
                        ORPHAN NAME
                    @else
                        Alan El
                    @endif
                </td>
                <td>
                    @if($thetype=='ytm')
                        CODE
                    @else
                        Kod
                    @endif
                </td>
                <td>
                    SIRA
                </td>
            </tr>
            @endforeach
            
       
    </section>

</article>

</body>
<style>
    body, *, table {
        font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';
    }

    table {
        width: 100%;
        margin: auto;
        border: 1px black solid;
    }

    td, th {
        font-size: 6px;
    }
    td{
        height:25px;
        text-align:center;
        padding:1.5px;
    }
    tr:nth-child(even) {background-color: #f2f2f2;}

    .A4 .sheet {
        height: 296mm;
    }

    h1, h2, h3, h4, h5, h6 {
        margin: 0;
        font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';
    }

    h1 {
        font-size: 68px;
        color: red !important;
    }

    h2 {
        font-size: 56px;
    }

    h3 {
        font-size: 48px;
    }

    h4 {
        font-size: 40px;
    }

    h5 {
        font-size: 30px;
    }

    h6 {
        font-size: 26px;
    }

    b {
        font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';
    }

    .align-right {
        text-align: right;
    }

    .align-left {
        text-align: left;
    }

    .align-center {
        text-align: center;
    }

    .align-justify {
        text-align: justify;
    }

    .margin-bottom-5 {
        margin-bottom: 5px;
    }

    .margin-bottom-10 {
        margin-bottom: 10px;
    }

    .margin-bottom-15 {
        margin-bottom: 15px;
    }

    .margin-bottom-20 {
        margin-bottom: 20px;
    }

    .margin-bottom-25 {
        margin-bottom: 25px;
    }

    .margin-bottom-30 {
        margin-bottom: 30px;
    }

    .margin-bottom-35 {
        margin-bottom: 35px;
    }

    .margin-bottom-40 {
        margin-bottom: 40px;
    }

    .margin-right-20 {
        margin-right: 20px;
    }

    .margin-right-40 {
        margin-right: 40px;
    }

    .margin-top-20 {
        margin-top: 20px;
    }

    .margin-top-40 {
        margin-top: 40px;
    }

    p {
        margin: 0
    }

    section {
        position: relative;
    }

    section footer {
        width: 100%;
    }

    section footer hr,
    section footer p {
        position: absolute;
        left: 15mm;
        right: 15mm;
    }

    section footer p {
        bottom: 15mm;
        text-align: center;
        font-size: 13px;
    }

    section footer hr.thick {
        bottom: 25mm;

    }

    section footer hr.thin {
        bottom: 22mm;
    }

    hr.thin {
        margin-top: 0px
    }

    hr.thick {
        background-color: rgb(0, 0, 0);
        height: 3px;
        margin-bottom: 10px;
        margin-top: 0;

    }

    header .right, header .left {
        width: 10%;
        vertical-align: middle;
    }

    header .center p {
        margin: 0 0 10px 0;
        font-size: 13px;
    }

    header h5, header h6 {
        margin: 0;
        line-height: 20px;
        color: #fe0002;
    }

    .head-tr {
        background-color: #EEE;
    }

    .ar-text {
        color: #35671b;
    }


    /* Start Override Css */
    .clear {
        clear: both;
    }

    .right-info {
        float: right;
        width: 70%;
    }

    .left-info {
        float: left;
        border: 2px solid #000;
        width: 150px;
        height: 150px;
    }

    .caption ul li {
        font-size: 12px;
    }

    .caption ul {
        margin: 0;
    }

    /* End Override Css */
</style>
</html>
