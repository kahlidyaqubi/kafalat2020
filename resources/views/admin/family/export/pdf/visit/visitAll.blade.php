<html>

<style>
    .page-break {
        page-break-after: always;
    }
</style>

<body style="position: relative;
  width: 21cm;
  height: 29.7cm;
  margin: 0 auto;
  padding: 1.5cm 1.5cm 0.5cm;
  color: rgb(118,146,60);
  background: #fff;
  font-family: Arial, sans-serif;
  font-size: 14px;
  line-height: 1.5;
">

@foreach ($families as $itemFamily)

    @php
        $family = $itemFamily;
        $parent = \App\Family::find($family->id);
        $parent->update(['is_sent' => 1]);

        $person = isset($family->person) ? $family->person : null;
        $membersCollection = isset($family->members) ? $family->members : collect();
    @endphp

    @include('admin.family.export.pdf.part.visit',compact('family'));

    <div class="page-break"></div>
@endforeach

</body>
</html>
