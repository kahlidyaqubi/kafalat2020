@if(!$persons->isEmpty())
    <table id="table">
        <thead>
        <th>الاسم الأول باللغة العربية</th>
        <th>الاسم الأول باللغة التركية</th>
        <th>تاريخ الميلاد</th>
        <th>رقم الهوية</th>
        </thead>
        <tbody id="addNewMemberTbody">
        @foreach($persons as $person)
            <tr>
                @if(!is_null($person->full_name))
                    <td colspan="2">{{ !is_null($person->full_name) ?$person->full_name : '-' }}</td>
                @else
                    <td colspan="2" >{{ !is_null($person->first_name)?$person->first_name : '-' }}</td>
                @endif
                    <td colspan="2">{{ !is_null($person->full_name_tr) ?$person->full_name_tr : '-' }}</td>
                <td>{{ !is_null($person->id_number) ?$person->id_number : '-' }}</td>
                <td>
                    <form action="{{ url('admin/families/addSingleMember/'.$person->id.'/'.$familyId) }}"
                          method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger"> إضافة</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p> لا يوجد نتائج</p>
@endif