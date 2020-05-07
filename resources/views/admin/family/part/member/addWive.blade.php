<tr>
    @php $person =((isset($member->person)) && (!is_null($member->person))) ? $member->person : null@endphp

    <td>{{ (!is_null($person)) && !is_null($person->full_name) ? $person->full_name: $person->first_name .' '. $person->second_name .' '. $person->third_name .' '. $person->family_name  }}</td>
    <td>{{ (!is_null($person)) ? $person->id_number : '-'  }}</td>
    <td>
    @if( (isset($member->relationship)) && (!is_null($member->relationship)) )
        {{ $member->relationship->name }}
    @else
        {{'-' }}
    @endif
    </td>
</tr>
