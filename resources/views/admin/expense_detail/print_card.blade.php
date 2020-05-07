<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
  <meta charset="utf-8">
  <!-- Load paper.css for happy printing -->
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">
@foreach($expense_details->where('delivery', 1) as $expense_detail)
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <div style="margin:0;padding:0">
        <img src="{{public_path('print_all_pages/images/header.png')}}" >
    </div>
    <br><br>
    <article>
        <section class="sheet padding-5mm">
             <!--<table class="t-head">-->
             <!--     <tr>-->
             <!--        <td>-->
             <!--            <div class="titles">-->
             <!--                 <h5>مشروع عائلة الاخوة</h5>-->
             <!--                 <br/>-->
             <!--                 <h5>KARDES AILE PROJESI</h5>-->
             <!--                 <h5>GAZZE - FILISTIN</h5>-->
             <!--           </div> -->
             <!--        </td>-->
             <!--       <td>-->
             <!--           <div class="logo">-->
             <!--               <img src="{{public_path('print_all_pages/images/1.png')}}"  alt="logo">-->
             <!--           </div>-->
             <!--        </td>-->
             <!--     </tr>-->
             <!-- </table>-->

    
          <div class="body">
              <!--<div class="flag-cont">-->
              <!--  <div class="flags">-->
              <!--      <img class="img1" src="{{public_path('print_all_pages/images/330477.svg')}}" alt="">-->
              <!--      <img  class="img2" src="{{public_path('print_all_pages/images/330467.svg')}}" alt="">-->
              <!--    </div>-->
              <!--    <div style="clear:both"></div>-->
              <!--</div>-->
    
             <br>
            <div class="content">
              <div class="title">
                <p>بيانات المكفول</p>
              </div>
              <div class="number">
                <span>KOD</span>:{{$expense_detail->family->code}}
              </div>
             <div style="clear:both"></div>
            </div>
    
            <div class="mah-info" dir="rtl">
               <br>
                <div class="form-input" >
                    <p style="width:100%">اسم المكفول:</p>
                </div>
                <div class="dots">
                    <span>
                    {{$expense_detail->family->person->full_name}}
                    </span>
                </div>
                <div style="clear:both"></div>
   <br>

                <div class="form-input">
                    <p> رقم الهوية:</p>
                </div>
                <div class="dots">
                    <span>
                   {{$expense_detail->family->person->id_number}}
                    </span>
                </div>
                <div style="clear:both"></div>
       <br>         
                 <div class="form-input">
                    <p> رقم الهاتف:</p>
                </div>
                <div class="dots">
                    <span> {{$expense_detail->family->mobile_one?$expense_detail->family->mobile_one:($expense_detail->family->mobile_two?$expense_detail->family->mobile_two:($expense_detail->family->telephone??"-"))}}                    
                    </span>
                </div>
                <div style="clear:both"></div>
                
<br>
                <div class="form-input">
                    <p> العنوان:</p>
                </div>
                <div class="dots">
                    <span>
                    <?php $item = $expense_detail->family ?>
                    @if($item->neighborhood){{$item->neighborhood->name ?? ""}}
                    /{{$item->neighborhood->city->name ?? ""}}
                    / {{$item->neighborhood->city->governorate->name ?? ""}}
                    / @endif {{$item->address}}                   
                    </span>
                </div>
                <div style="clear:both"></div>
                <br>
                <div class="form-input">
                     <p style="color:red"> اسم الوكيل:</p>
                </div>
                <div class="dots">
                    <span>
    {{$expense_detail->family->representative?$expense_detail->family->representative->full_name:"-"}}               
                    </span>
                </div>
                <div style="clear:both"></div>
<br>
                <div class="form-input">
                    <p style="color:red"> هوية الوكيل:</p>
                </div>
                <div class="dots">
                    <span>
{{$expense_detail->family->representative?$expense_detail->family->representative->id_number:"-"}}
                    </span>
                </div>
                <div style="clear:both"></div>

            </div>
    
    
            
            <div class="content-m">
                <div class="title-m">
                    <p>بيانات الكافل</p>
                </div>
                <div class="number-m"> </div>
                <div style="clear:both"></div>
            </div>
    
              <div class="form" dir="rtl">
                <br>
                <div class="form-input" >
                    <p style="width:100%">اسم المكفول:</p>
                </div>
                <div class="dots">
                    <span>
                    @foreach($expense_detail->sponsors as  $sponsor)
                                    {{$sponsor->name}}
                                     / 
                                @endforeach
                    </span>
                </div>
                <div style="clear:both"></div>
              </div>
    <br><br><br/><br/>
          </div>

          <div class="footer1">
		  <?php $settings = \App\Setting::whereIn('key', ['sessionEnd', 'footer', 'name', 'number_one', 'number_two', 'logo', 'address', 'fax', 'phone', 'email', 'facebook', 'twitter', 'youtube', 'welcomeBackground', 'welcomeMainText', 'welcomeSubText', 'welcomeReadMoreLink', 'welcomeReadMoreText'])->get(); ?>
                <ul>
                    <li>>> رقم جوال :  <span>{{$settings->where('key', 'number_one')->first()->value}}</span> </li>
                    <li>>> رقم الهاتف : <span>{{$settings->where('key', 'phone')->first()->value}}</span></li>
                    <li>>>الايميل: <span>{{$settings->where('key', 'email')->first()->value}}</span></li>
                    <li>>>العنوان: <span>
                        {{$settings->where('key', 'address')->first()->value}}</span></li>
                    
                </ul>
          </div>
        </section>
    </article>
    <br/>

    
    <article>
      <section class="sheet">
        <div class="header align-center">
            <br/><br/>           <h3>
              مشروع عائلات الاخوة العام - {{$expense_detail->expense->year}}
            </h3> <br/><br/>
      </div><br/><br/>
      <div class="grid">
          <table>
              <tr>
                <th>مارس</th>
                <th>فبراير</th>
                <th>يناير</th>
              </tr>
              <tr>
                <td></td>
                <td> </td>
                <td></td>
              </tr>
              <tr>
                <th>يونيو</th>
                <th>مايو</th>
                <th>ابريل</th>
              </tr>
              <tr>
                <td></td>
                <td> </td>
                <td></td>
              </tr>
              <tr>
                <th>سبتمبر</th>
                <th>أغسطس</th>
                <th>يوليو</th>
              </tr>
              <tr>
                <td></td>
                <td> </td>
                <td></td>
              </tr>
              <tr>
                <th>ديسمبر</th>
                <th>نوفمبر</th>
                <th>اكتوبر</th>
              </tr>
              <tr>
                <td></td>
                <td> </td>
                <td></td>
              </tr>
            </table>
      </div>
      
      <br/><br/>
      <ul class="footer2">
        <li>>> مدة الكفالة عام واحد</li>
        <li>>> الرجاء إصطحاب الكرت عند الإستلام</li>
        <li>>> الإلتزام بالموعد والوقت المحدد للإستلام</li>
      </ul>
      </section>

  </article>
@endforeach
</body>
  <style>

html {
  font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular'; /* 1 */
  -ms-text-size-adjust: 100%; /* 2 */
  -webkit-text-size-adjust: 100%; /* 2 */
}

body {
    margin: 0;  padding:0;
    box-sizing: border-box;
}

article,aside,details,figcaption,figure,footer,header,hgroup,main,menu,nav,section,summary {
  display: block;
}
audio,canvas,progress,video {
  display: inline-block; /* 1 */
  vertical-align: baseline; /* 2 */
}
audio:not([controls]) {
  display: none;
  height: 0;
}
[hidden], template {
  display: none;
}

/* Links
   ========================================================================== */
a {  background-color: transparent;}
a:active,a:hover {  outline: 0; }

/* Text-level semantics
   ========================================================================== */

abbr[title] {  border-bottom: 1px dotted;}

b,strong {  font-weight: bold;}

dfn {  font-style: italic;}

h1 {  font-size: 2em;  margin: 0.67em 0;}

mark {  background: #ff0;  color: #000;}

small {  font-size: 80%;}

sub,sup {
  font-size: 75%;
  line-height: 0;
  position: relative;
  vertical-align: baseline;
  font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';
}

sup {  top: -0.5em;}
sub {  bottom: -0.25em;}


/* Remove border when inside `a` element in IE 8/9/10. */

img {  border: 0;}
svg:not(:root) {  overflow: hidden;}

/* Grouping content
   ========================================================================== */
/** * Address margin not present in IE 8/9 and Safari.*/

figure { margin: 1em 40px;}

/** * Address differences between Firefox and other browsers.*/
hr {  box-sizing: content-box;  height: 0;}

/** * Contain overflow in all browsers. */

pre {  overflow: auto;}

/** * Address odd `em`-unit font size rendering in all browsers. */

code,kbd,pre,samp {
  font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';
  font-size: 1em;
}

/* Forms
   ========================================================================== */
button,input,optgroup,select,textarea {
  color: inherit; 
  font: inherit; 
  margin: 0; 
}

/** * Address `overflow` set to `hidden` in IE 8/9/10/11. */

button {  overflow: visible;}

button,select {  text-transform: none;}

button,html input[type="button"],
input[type="reset"],input[type="submit"] {
  -webkit-appearance: button;  
  cursor: pointer; 
}


/** * Re-set default cursor for disabled elements. */

button[disabled],html input[disabled] {cursor: default;}

/* Remove inner padding and border in Firefox 4+. */

button::-moz-focus-inner,input::-moz-focus-inner {
  border: 0;  padding: 0;
}

input {  line-height: normal;}

input[type="checkbox"],input[type="radio"] {
  box-sizing: border-box; /* 1 */
  padding: 0; /* 2 */
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  height: auto;
}

input[type="search"] {
  -webkit-appearance: textfield; /* 1 */
  box-sizing: content-box; /* 2 */
}

input[type="search"]::-webkit-search-cancel-button,
input[type="search"]::-webkit-search-decoration {
  -webkit-appearance: none;
}

/* Define consistent border, margin, and padding.*/

fieldset {
  border: 1px solid #c0c0c0;
  margin: 0 2px;
  padding: 0.35em 0.625em 0.75em;
}
legend {
  border: 0; /* 1 */
  padding: 0; /* 2 */
}
textarea {  overflow: auto;}
optgroup {  font-weight: bold;}

/* Tables
   ========================================================================== */
table {
    border-collapse: collapse;
  border-spacing: 0;
}
td,th {  padding: 0;}

* {  box-sizing: border-box;  -webkit-box-sizing: border-box;
font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';
    
}
span, p, li, sub,div {
        font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';
    !important;
    }
.fontsize-11 {  font-size: 11px !important;}

.bg-gray {  background: #EEE !important;}

.float-right {  float: right !important;}

.parent_div {  width: 100%;}

.parent_div:after {  clear: both;}

 table td {  font-size: 10px;  height: 24px;}

.parent_div table tr td:nth-child(2) table td:last-child {
  border-left: 1px solid;
}

.clear {  clear: both;}

.total-hour h6 {
    width: 96%;
  margin: auto;
  text-align: center;
  padding: 5px;
}

@media screen, print {
/*  .head {    position: relative;*/
/*    }*/
/*.background {*/
/*    position: relative;*/
/*    background-color: orangered;*/
/*    width: 100%;*/
/*    height: 100px;*/
/*  }*/
  
  .t-head{
    background-color: orangered;
    width: 100%;
    height: 50px;

  }
    .t-head td{    margin:0;    padding:20px;  }
  .logo {
    background-color: orange;
    border-top-left-radius: 2rem;
    border-bottom-right-radius: 2rem;
    padding: 1rem 1rem;
    width: 30%;
    background-clip: content-box;
    border: 1px solid #777;
    padding: 3px;
  }

  .titles {
    width: 40%;
  }


  .flag-cont{
    margin:5px auto;
        /*width: 100%;*/
  }

  .flags {
    background-color: orange;
    margin:auto;
    width: 50%;
    border-radius: 1rem;
    background-clip: content-box;
    border: 1px solid #777;
    padding: 3px;
  }
  .img1,.img2 {
    width: 20%;
    float:right;
  }

   .img2{ float:left; }
  
  .content{
    border: 1px solid orangered;
    border-radius: 2rem;
    margin:10px 0;
  }
  
  .title {
    /*background-color: orangered;*/
    background-color: #f26738;
    color: #fff;
    padding: .5rem .5rem;
    border-top-right-radius: 2rem;
    border-bottom-right-radius: 2rem;
    padding-left: 40px;
    float:right;
    width: 20%;
  }
  
  .number {
    padding-left: 2rem;
    font-weight: bold;
    float:left;
    width: 50%;
    text-align:left;
    padding: .5rem .5rem;
  } 
  
    .content-m{
        margin-top:30px;
        border-bottom: 1px solid orangered;
        border-radius: 0 2rem 2rem 0;
    }
  
  .title-m {
    background-color: #f26738;
    color: #fff;
    padding: .5rem .5rem;
    padding-left: 40px;
    float:right;
    width: 20%;
    border-radius: 0 2rem 2rem 0;
  }
  
  .number-m {
    padding-left: 2rem;
    font-weight: bold;
    float:left;
    width: 50%;
    text-align:left;
    padding: .5rem .5rem;
  }  


    .mah-info{
        margin:10px;
    }
 
  .form-input {
    float:right;
    width: 30%;
  }

  .form-input p {
    width: 88px;
  }

  .dots {
    float:left;
    width: 70%;
    border-bottom: 1px dashed #555;
    text-align:center;

    }
  .form {
    display: grid;
    margin-right: 1rem;
  }

  .header{
      background-color: orange;
  }

  .header h1 {
    text-align: center;
    padding: 12px;
  }

  table {
    font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';
    border-collapse: collapse;
    width: 100%;
    margin-top: 2rem;
  }

  th {
      background-color: #000;
      color: #fff;
  }
  
  td, th {
    border: 1px solid #000;
    text-align: center;
    padding: 8px;
  }

  td {
     padding: 60px 8px;
  }
  
  tr:nth-child(even) {
    background-color: transparent;
  }

  .number span {
    color: orangered;
    font-weight: bold;
  }

  .content-1{
    display: flex;
  }

  .content-1 .title {
    flex: 1;
  }

  .content-1 .number {
    flex: 5;
    border-bottom: 1px solid orangered;
    margin-top: 45px;
  }

  .form-input-1 {
    margin: 20px 0;
  }

  .footer1 {
    background-color: orangered;
    border-top: 2px solid #000;
    padding: 0;
 }
   .footer1 ul {padding: 10px; }
  .footer1 li {list-style: none;color: #FFF; font-size:15px; margin:10px 0;}

  .footer2 {
    list-style: none;    background-color: orangered;    padding: 10px;
  }
  .footer2 li {color: #FFF; font-size:15px; margin:10px 0;  }
}
   

body * {
    font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';  
    
}
    .A4 .sheet {
        height: 296mm;
    }
    
    .sheet {
        height: 296px;
    }
    h1 , h2, h3 , h4, h5 , h6 ,*,span,ol,li{
        margin:0;
        font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';
    }
    h1 {
        font-size: 34px;
    }
    h2 {
        font-size: 28px;
    }
    h3 {
        font-size: 24px;
    }
    h4 {
        font-size: 20px;
    }
    h5 {
        font-size: 15px;
    }
    h6 {
        font-size: 13px;
    }
    b {
        font-family: 'examplefont', sans-serif, 'DroidArabicNaskhRegular';
    }
    .align-right {    text-align: right;}
    .align-left {    text-align: left;  }
    .align-center {   text-align: center;    }
    .align-justify {text-align: justify;    }
    .margin-bottom-5 {   margin-bottom: 5px;}
    .margin-bottom-10 { margin-bottom: 10px;}
    .margin-bottom-15 { margin-bottom: 15px;}
    .margin-bottom-20 { margin-bottom: 20px;}
    .margin-bottom-25 { margin-bottom: 25px;}
    .margin-bottom-30 {margin-bottom: 30px;}
    .margin-bottom-35 {margin-bottom: 35px;    }
    .margin-bottom-40 {        margin-bottom: 40px;    }
    .margin-right-20 {      margin-right: 20px;    }
    .margin-right-40 {      margin-right: 40px;    }
    .margin-top-20 {      margin-top: 20px;    }    
    .margin-top-40 {      margin-top: 40px;    }
    
    p {        margin: 0    }
    section {        position: relative;    }
    section footer {      width: 100%;    }
    section footer hr, section footer p {
        position: absolute;      left: 15mm;       right: 15mm;
    }
    section footer p {        bottom: 15mm;
        text-align: center;        font-size: 13px;
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

    .caption ul {  margin: 50px 0; }
    .caption ul li {
      font-size: 30px;
     margin: 50px 0;
          padding: 50px 0;


    }

    </style>
</html>
