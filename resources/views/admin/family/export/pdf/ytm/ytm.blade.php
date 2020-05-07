<html>

@php

    $settings = \App\Setting::whereIn('key', ['sessionEnd', 'footer', 'name', 'number_one', 'number_two', 'logo', 'address', 'fax', 'phone', 'email', 'facebook', 'twitter', 'youtube', 'welcomeBackground', 'welcomeMainText', 'welcomeSubText', 'welcomeReadMoreLink', 'welcomeReadMoreText'])->get();
$name = $settings->where('key', 'name')->first();
$address = $settings->where('key', 'address')->first();
$phone = $settings->where('key', 'phone')->first();
$email = $settings->where('key', 'email')->first();

$person = isset($family->person) ? $family->person : null;

$representative = isset($family->representative) ? $family->representative : null;

$membersCollection = isset($family->members) ? $family->members : collect();

@endphp

<body style="position: relative;
  width: 21cm;
  height: 29.7cm;
  margin: 0 auto;
  padding: 1.5cm 1.5cm 0.5cm;
  color: rgb(38,38,38);
  background: #fff;
  font-family: Arial, sans-serif;
  font-size: 14px;
  line-height: 1.15;
">

@include('admin.family.export.pdf.part.ytm',compact('family'));

</body>
</html>
