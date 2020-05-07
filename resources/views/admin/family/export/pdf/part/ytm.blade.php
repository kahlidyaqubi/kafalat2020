<header style="overflow: hidden;">
    <table style="border: 0; width: 100%">
        <tbody>
        <tr>
            <td><img src="{{ public_path() .'/assets/images/logo-pdf.jpg' }}" style="width: 3.5cm;"></td>
            <td>
                <h2 style="width: 10cm; text-align: center; margin: 0 auto">
                    YARDIMELİ ULUSLAR ARASI İNSANİ YARDIM DERNEĞİ
                    <br>
                    نموذج مشروع الايتام
                    <br>
                    YETİM PROJESİ FORMU
                </h2>
            </td>
            <td><img src="{{ public_path() .'/assets/images/user-img-pdf.jpeg' }}" style="width: 3.5cm;"></td>
        </tr>
        </tbody>
    </table>
</header>

<main style="overflow: hidden;">
    <table style="width: 99.5%; text-align: left; border-collapse: collapse; margin: 1cm auto;">
        <thead>
        <tr>
            <th colspan="2"
                style="background: rgb(242,242,242)!important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>
                    YETİM BİLGİLERİ / ORPHAN INFORMATION
                </strong>
            </th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Grup No</strong>
                <br>
                <em><small>(Group Number)</small></em>
            </td>
            <td style="width: 35%; border: 1px solid #000;">{{ $family->group_number }}</td>
            <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Yetim No</strong>
                <br>
                <em><small>(Orphan Number)</small></em>
            </td>
            <td style="width: 30%; border: 1px solid #000;">{{ !is_null($person) ? $person->id_number : '-' }}</td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Adı Soyadı</strong>
                <br>
                <em><small>(Name Surname)</small></em>
            </td>
            <td colspan="3" style="width: 80%; border: 1px solid #000;">
                {{ !is_null($person) ? $person->first_name_tr : '-' }}
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Baba Adı</strong>
                <br>
                <em><small>(Fathers’ Name)</small></em>
            </td>
            <td colspan="3" style="width: 80%; border: 1px solid #000;">
                {{ !is_null($person) ? $person->second_name_tr : '-' }}
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Doğum Tarihi</strong>
                <br>
                <em><small>(Date of Birth)</small></em>
            </td>
            <td style="width: 35%; border: 1px solid #000;">
                {{ !is_null($person) ? $person->date_of_birth : '-' }}
            </td>
            <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Doğum Yeri</strong>
                <br>
                <em><small>(Place of Birth)</small></em>
            </td>
            <td style="width: 30%; border: 1px solid #000;">
                {{ !is_null($person) ? isset($person->birthPlace) ? $person->birthPlace->name_tr : '-' : '-' }}
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Cinsiyet</strong>
                <br>
                <em><small>(Gender)</small></em>
            </td>
            <td style="width: 35%; border: 1px solid #000;">
                {{ !is_null($person) ? ($person->gander == 'M' ? 'erkek' : 'kadın') : '-' }}
            </td>
            <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Fert Sayısı</strong>
                <br>
                <em><small>(Number of People at Family)</small></em>
            </td>
            <td style="width: 30%; border: 1px solid #000;">
                {{ $family->mobile_one  }}
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Baba Ölüm Sebebi</strong>
                <br>
                <em><small>(Death Reason of Father)</small></em>
            </td>
            <td style="width: 35%; border: 1px solid #000;">
                {{ $family->father_death_reason }}
            </td>
            <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Ölüm Tarihi</strong>
                <br>
                <em><small>(Date of Death)</small></em>
            </td>
            <td style="width: 30%; border: 1px solid #000;">
                {{ (!is_null($family->father_death_date_old)) ? $family->father_death_date_old : $family->father_death_date }}
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Anne Ölüm Sebebi</strong>
                <br>
                <em><small>(Death Reason of Mother)</small></em>
            </td>
            <td style="width: 35%; border: 1px solid #000;">
                {{ $family->mother_death_reason }}
            </td>
            <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Ölüm Tarihi</strong>
                <br>
                <em><small>(Date of Death)</small></em>
            </td>
            <td style="width: 30%; border: 1px solid #000;">
                {{ (!is_null($family->mother_death_date_old)) ? $family->mother_death_date_old : $family->mother_death_date }}
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Adres</strong>
                <br>
                <em><small>(Adress)</small></em>
            </td>
            <td colspan="3" style="width: 80%; border: 1px solid #000;">
                {{  $family->address }}
            </td>
        </tr>
        </tbody>
    </table>

    <table style="width: 99.5%; text-align: left; border-collapse: collapse; margin: 1cm auto;">
        <thead>
        <tr>
            <th colspan="3"
                style="background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact; border: 1px solid #000;">
                <strong>
                    KARDEŞ BİLGİLERİ / SIBLINGS INFORMATION
                </strong>
                <br>
            </th>
            <th colspan="2"></th>
        </tr>
        </thead>

        <tbody>
        @foreach ($membersCollection->sortBy('date_of_birth') as $key => $item)
            @php $personMember = isset($item->person) ? $item->person : null;  @endphp
            <tr>
                <td style="width: 5%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                    {{ $key+1}}
                </td>
                <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                    <strong>Adı Soyadı</strong>
                    <br>
                    <em><small>(Name Surname)</small></em>
                </td>
                <td style="width: 35%; border: 1px solid #000;">
                    {{ !is_null($personMember) ? $personMember->first_name_tr : '-' }}
                    {{ !is_null($personMember) ? $personMember->family_name_tr : '-' }}
                </td>
                <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                    <strong>Doğum Tarihi</strong>
                    <br>
                    <em><small>(Date of Birth)</small></em>
                </td>
                <td style="width: 30%; border: 1px solid #000;">
                    {{ !is_null($personMember) ? $personMember->date_of_birth : '-' }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table style="width: 99.5%; text-align: left; border-collapse: collapse; margin: 1cm auto;">
        <thead>
        <tr>
            <th colspan="2"
                style="background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact; border: 1px solid #000;">
                <strong>
                    EĞİTİM BİLGİLERİ / EDUCATION INFORMATION
                </strong>
            </th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Eğitim Düzeyi</strong>
                <br>
                <em><small>(Educational level)</small></em>
            </td>
            <td style="width: 35%; border: 1px solid #000;">
                {{ ((!is_null($person)) && (isset($person->qualification)) && (!is_null($person->qualification))) ? $person->qualification->name_tr : '-' }}
            </td>
            <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Sınıf - Bölüm</strong>
                <br>
                <em><small>(Grade - Major)</small></em>
            </td>
            <td style="width: 30%; border: 1px solid #000;">
                {{ ((!is_null($person)) && (isset($person->qualificationLevel)) && (!is_null($person->qualificationLevel))) ? $person->qualificationLevel->name_tr : '-' }}
            </td>
        </tr>
        </tbody>
    </table>

    <table style="width: 99.5%; text-align: left; border-collapse: collapse; margin: 1cm auto;">
        <thead>
        <tr>
            <th colspan="2"
                style="background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact; border: 1px solid #000;">
                <strong>
                    VELİ BİLGİLERİ / GUARDIAN INFORMATIONl
                </strong>
            </th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Adı Soyadı</strong>
                <br>
                <em><small>(Name Surname)</small></em>
            </td>
            <td colspan="3" style="width: 80%; border: 1px solid #000;">
                {{ ((!is_null($representative)) ? $representative->first_name : '-') }}
                {{  ((!is_null($representative)) ? $representative->family_name : '-') }}
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Yakınlık Derecesi</strong>
                <br>
                <em><small>(Degree)</small></em>
            </td>
            <td style="width: 35%; border: 1px solid #000;">
                {{ (isset($family->representative_relationship)) ? $family->representative_relationship->name_tr : '-' }}
            </td>
            <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Mesleği</strong>
                <br>
                <em><small>Occupation</small></em>
            </td>
            <td style="width: 30%; border: 1px solid #000;">
                {{ (!is_null($representative)) ? ((!is_null($representative->work)) ? ($representative->work == 0 ? 'çalışmıyor' : 'eserler') : '-') : '-' }}
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Telefon</strong>
                <br>
                <em><small>(Telephone) </small></em>
            </td>
            <td style="width: 35%; border: 1px solid #000;">
                {{ $family->mobile_one }}  {{ $family->mobile_two }}
            </td>
            <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Email</strong>
                <br>
                <em><small>(Email)</small></em>
            </td>
            <td style="width: 30%; border: 1px solid #000;">
                {{ (!is_null($person)) ? $person->email : "-" }}
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>ADRES</strong>
                <br>
                <em><small>(Adress)</small></em>
            </td>
            <td colspan="3" style="width: 80%; border: 1px solid #000;">
                {{ $family->address }}
            </td>
        </tr>
        </tbody>
    </table>

    <table style="width: 99.5%; text-align: left; border-collapse: collapse; margin: 1cm auto;">
        <thead>
        <tr>
            <th colspan="2"
                style="background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact; border: 1px solid #000;">
                <strong>
                    ARACI KURUM/INTERMEDIARY INFORMATION
                </strong>
            </th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Kurum Adı</strong>
                <br>
                <em><small>(İntermediary’Name)</small></em>
            </td>
            <td colspan="3" style="width: 80%; border: 1px solid #000;">
                {{ $name->value }}
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Telefon</strong>
                <br>
                <em><small>(Telephone)</small></em>
            </td>
            <td style="width: 35%; border: 1px solid #000;">
                {{  $phone->value }}
            </td>
            <td style="width: 15%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Email</strong>
                <br>
                <em><small>(Email)</small></em>
            </td>
            <td style="width: 30%; border: 1px solid #000;">
                <a href="mailto:{{ $email->value }}">{{ $email->value }}</a>
            </td>
        </tr>
        <tr>
            <td style="width: 20%; background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>ADRES</strong>
                <br>
                <em><small>(Adress)</small></em>
            </td>
            <td colspan="3" style="width: 80%; border: 1px solid #000;">
                {{  $address->value }}
            </td>
        </tr>
        </tbody>
    </table>

    <table style="width: 99.5%; text-align: left; border-collapse: collapse; margin: 1cm auto;">
        <tbody>
        <tr>
            <td style="width: 20%;  background: rgb(242,242,242) !important; -webkit-print-color-adjust: exact;  border: 1px solid #000;">
                <strong>Not</strong>
                <br>
                <em><small>(Note)</small></em>
            </td>
            <td colspan="3" style="width: 80%; border: 1px solid #000; height: 3cm;">
                {{ $family->note_turkey }}
            </td>
        </tr>
        </tbody>
    </table>


</main>
