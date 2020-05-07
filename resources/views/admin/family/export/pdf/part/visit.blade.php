
<header style="overflow: hidden;">
    <table style="border:5px double rgb(192,80,77); width: 100%; text-align: center">
        <tbody>
        <tr>
            <td><img src="{{ public_path() .'/assets/images/logo-pdf.jpeg' }}" style="width: 3cm; "></td>
            <td>
                <h2 style="width: 12.5cm; margin: 0 auto;">
                    YARDIMELİ ULUSLARARASI İNSANI YARDIM DERNEĞİ GAZZE OFİSİ - FİLİSTİNLİ KARDEŞ AİLE FORMU
                </h2>
            </td>
            <td><img src="{{ public_path() .'/assets/images/family-img-pdf.jpeg' }}" style="width: 2.5cm; "></td>
        </tr>
        </tbody>
    </table>
</header>

<main style="overflow: hidden;">
    <table style="width: 99.5%; margin: 1cm auto; text-align: center; font-weight: bold; border-spacing: 0px;">
        <thead>
        <tr>
            <th style=" border: 5px double rgb(192,80,77); width: 33.3%;">AİLE MUHASEBE KODU</th>
            <th style=" border: 5px double rgb(192,80,77); width: 33.3%;">KARDEŞ AİLE KAYITLI ADI</th>
            <th style=" border: 5px double rgb(192,80,77); width: 33.3%;">AİLE MUHTAÇLIK DURUMU</th>
        </tr>
        </thead>
        <tbody>
        <tr style="border: 0; height: 0.4cm;"></tr>
        <tr style="color: #000">
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0;">{{ $family->code }}</td>
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0;">{{ !is_null($person) ? $person->full_name_tr : '-' }}</td>
            <td style="border: 2px dashed rgb(192,80,77);">{{ isset($family->status) ? !is_null($family->status->name_tr) ? $family->status->name_tr : '-' : '-' }}</td>
        </tr>
        </tbody>
    </table>

    <table style="width: 99.5%; margin: 1cm auto; text-align: center; font-weight: bold; border-spacing: 0px;">
        <thead>
        <tr>
            <th style=" border: 5px double rgb(192,80,77); width: 25%;">PROJE ADI</th>
            <th style=" border: 5px double rgb(192,80,77); width: 25%;">ÜLKE</th>
            <th style=" border: 5px double rgb(192,80,77); width: 25%;">ŞEHİR</th>
            <th style=" border: 5px double rgb(192,80,77); width: 25%;">BÖLGE</th>
        </tr>
        </thead>
        <tbody>
        <tr style="border: 0; height: 0.4cm;"></tr>
        <tr style="color: #000">
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0;">KARDEŞ AİLE PROJES</td>
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0;">FİLİSTİN</td>
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0;">{{ isset($family->city) ? $family->city->name_tr : '-' }}</td>
            <td style="border: 2px dashed rgb(192,80,77);">{{ isset($family->neighborhood) ? $family->neighborhood->name_tr : '-' }}</td>
        </tr>
        </tbody>
    </table>

    <table style="width: 99.5%; margin: 1cm auto; text-align: center; font-weight: bold; border-spacing: 0px;">
        <thead>
        <tr>
            <th style=" border: 5px double rgb(192,80,77); width: 20%;">KİMLİK NO</th>
            <th style=" border: 5px double rgb(192,80,77); width: 20%;">CEP TELEFON NO. 1</th>
            <th style=" border: 5px double rgb(192,80,77); width: 20%;">CEP TELEFON NO. 2</th>
            <th style=" border: 5px double rgb(192,80,77); width: 20%;">TELEFON NO.</th>
            <th style=" border: 5px double rgb(192,80,77); width: 20%;">AİLE RES. MESLEĞİ</th>
        </tr>
        </thead>
        <tbody>
        <tr style="border: 0; height: 0.4cm;"></tr>
        <tr style="color: #000">
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0;">{{ !is_null($person) ? $person->id_number : '-' }}</td>
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0;"><span
                        style="color: rgb(118,146,60);">{{ $family->mobile_one }} </span>
            </td>
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0;"><span
                        style="color: rgb(118,146,60);">{{ $family->mobile_two }} </span>
            </td>
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0;"><span
                        style="color: rgb(118,146,60);">{{ $family->telephone }} </span>
            </td>
            <td style="border: 2px dashed rgb(192,80,77);">{{ isset($family->job_type) ? $family->job_type->name_tr : '-' }}</td>
        </tr>
        </tbody>
    </table>

    <table style="width: 99.5%; margin: 1cm auto 0.3cm; text-align: center; font-weight: bold; border-spacing: 0px;">
        <tbody>
        <tr>
            <td style="border: 2px solid rgb(192,80,77); border-right: 0; width: 15%;">ZİY. TAR.</td>
            <td style="border: 2px solid rgb(192,80,77); color: #000000; width: 15%;">{{ $family->visit_date }}</td>
            <td style="border: 0; width: 2%;"></td>
            <td style="border: 5px double rgb(192,80,77); width: 36%;">AİLE FERTLERİ</td>
            <td style="border: 0; width: 2%;"></td>
            <td style="border: 2px solid rgb(192,80,77); border-right: 0; width: 15%;">ÖĞR. NO.</td>
            <td style="border: 2px solid rgb(192,80,77); color: #000000; width: 15%;">{{ $family->id_university }}</td>
        </tr>
        </tbody>
    </table>

    // family
    <table style="width: 99.5%; margin: 0.3cm auto 1cm; text-align: center; font-weight: bold; border-spacing: 0px;">
        <thead>
        <tr>
            <th style=" border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0; width: 10%;">SIRA</th>
            <th style=" border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0; width: 30%;">ADI SOYADI
            </th>
            <th style=" border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0; width: 20%;">YAŞI</th>
            <th style=" border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0; width: 20%;">YAKINLIĞI
            </th>
            <th style=" border: 2px dashed rgb(192,80,77); border-bottom: 0; width: 20%;">MESLEK</th>
        </tr>
        </thead>
        <tbody>
        <tr style="color: #000">
            <th style="border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0; color: rgb(118,146,60);">
                1
            </th>
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0;">{{ !is_null($person) ? $person->first_name_tr : '-'}}</td>
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0;">{{ !is_null($person) ? $person->date_of_birth : '-' }}</td>
            <td style="border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0;">{{ !is_null($relationShip) ? $relationShip->name_tr : '-' }}</td>
            <td style="border: 2px dashed rgb(192,80,77); border-bottom: 0;">{{ (!is_null($person) && (!is_null($person->health))) ? $person->health == 0 ? 'SAĞLAM' : 'HASTA' : '-' }}
                {{  ((!is_null($person)) && (isset($person->qualification)) && (!is_null($person->qualification))) ? $person->qualification->name_tr : '-' }}
            </td>
        </tr>

        @foreach ($membersCollection->sortBy('date_of_birth') as $key => $item)
            @php $personMember = isset($item->person) ? $item->person : null; @endphp
            <tr style="color: #000">
                <th style="border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0; color: rgb(118,146,60);">
                    {{ $key +2 }}
                </th>
                <td style="border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0;">{{ !is_null($personMember) ? $personMember->first_name_tr : '-' }}</td>
                <td style="border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0;">{{ !is_null($personMember) ? $personMember->date_of_birth : '-' }}</td>
                <td style="border: 2px dashed rgb(192,80,77); border-right: 0; border-bottom: 0;">{{ isset($item->relationship) ? $item->relationship->name_tr : null }}</td>
                <td style="border: 2px dashed rgb(192,80,77); border-bottom: 0;">{{ (!is_null($personMember) && (!is_null($personMember->health))) ? $personMember->health == 0 ? 'SAĞLAM' : 'HASTA' : '-' }}
                    {{  ((!is_null($personMember)) && (isset($personMember->qualification)) && (!is_null($personMember->qualification))) ? $personMember->qualification->name_tr : '-' }}
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <table style="width: 99.5%; margin: 1cm auto; text-align: center; font-weight: bold; border-spacing: 0px;">
        <thead>
        <tr>
            <th style=" border: 5px double rgb(192,80,77); width: 30%;">AÇIKLAMA</th>
            <th style="width: 70%;"></th>
        </tr>
        </thead>
        <tbody>
        <tr style="border: 0; height: 0.4cm;"></tr>
        <tr style="color: #000; text-align: left;">
            <td colspan="2" style="border: 2px dashed rgb(192,80,77);">{{ $family->note_turkey }}</td>
        </tr>
        </tbody>
    </table>

    <table style="width: 99.5%; margin: 1cm auto; text-align: center; font-weight: bold; border-spacing: 0px;">
        <tbody>
        <tr style="color: #000;">
            <td style="border: 2px dashed rgb(192,80,77); background: rgb(251,212,180)!important; -webkit-print-color-adjust: exact;">
                <p>
                    Adres: Yeşilova Mah Akdeniz Cad No:2 Küçükçekmece İSTANBUL Tel: 0212 541 48 00 Faks: 0212 541 92 00
                </p>
                <p>
                    <strong>Email: </strong>
                    <a style="margin-right: 1cm;"
                       href="mailto:yardimeli@yardimeli.org.tr">yardimeli@yardimeli.org.tr</a>
                    <a href="mailto:www.yardimeli.org.tr">www.yardimeli.org.tr</a>
                </p>
            </td>
        </tr>
        </tbody>
    </table>

</main>
