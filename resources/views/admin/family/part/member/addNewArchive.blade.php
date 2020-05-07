<tr>
    @php $person =((isset($member->person)) && (!is_null($member->person))) ? $member->person : null@endphp

    <td>{{ (!is_null($person)) && !is_null($person->full_name) ? $person->full_name: $person->first_name .' '. $person->family_name  }}</td>
    <td>{{ (!is_null($person)) ? $person->first_name_tr : '-'  }}</td>
    <td>{{ (!is_null($person)) ? $person->date_of_birth : '-'  }}</td>
    <td>{{ (!is_null($person)) ? $person->id_number : '-'  }}</td>
    <td>
    @if( (isset($member->relationship)) && (!is_null($member->relationship)) )
        {{ $member->relationship->name }}
    @else
        {{'-' }}
    @endif
    <td>
    @if( (isset($member->person)) && (!is_null($member->person)) )
        @if( (isset($member->person->qualification)) && (!is_null($member->person->qualification)) )
            {{ $member->person->qualification->name }}
        @else
            {{ '-' }}
        @endif
    @endif
    <td>{{ !is_null($member->person->work) ? $member->person->work == 0 ? 'لايعمل' : 'يعمل' :'-'}}</td>
    <td>{{ !is_null($member->person->health_status) ? $member->person->health_status == 0 ? 'سليم' : 'مريض' :'-' }}</td>
    <td>
        @php $arrayData = []; @endphp
        @if ((isset($person->diseases)) && (!is_null($person->diseases)))
            @foreach ($person->diseases as $item)
                @if ((isset($item->disease)) && (!is_null($item->disease)))
                    @php  array_push($arrayData, $item->disease->name); @endphp
                @endif
            @endforeach
        @endif

        @php echo implode(" | ", $arrayData); @endphp
    </td>
    <td>
        {{ (isset($member->person) && (!is_null($member->person))) ? ((isset($member->person->social_status)) && (!is_null($member->person->social_status))) ? $member->person->social_status->name:'-':'-' }}
    </td>
    <td>{{ (!is_null($person)) ? $person->old_status : '-'  }}</td>
</tr>
