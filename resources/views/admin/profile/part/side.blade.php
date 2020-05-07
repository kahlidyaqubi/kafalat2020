<div class="col s12 m4">
    <div class="card">
        <div class="card-content" style="padding-bottom: 0px">
            <div class="center-align m-t-30">
                @if(((!is_null($user->image)) && (!is_null($user->image)) && (($user->image != ''))))
                    <img class="circle" height="150" width="150" src="{{ asset($user->image) }}">
                @else
                    <img src="../../assets/images/users/2.jpg" class="circle" height="150" width="150"/>
                @endif
                <h4 class="card-title m-t-10"> {{ !is_null($user->user_name) ? $user->user_name : '-' }} </h4>
                <h6 class="card-subtitle">
                    {{ isset($user->department)? '  قسم  ' . $user->department->name : '-' }}
                </h6>
            </div>
        </div>
        <hr>
        <div class="card-content">
            <small>البريد الالكتروني
            </small>
            <h6>   {{ !is_null($user->email) ? $user->email :'-' }} </h6>
            <small>الجوال</small>
            <h6>
                {{ $user->mobile_one }}
                @if(!is_null($user->mobile_two))
                    {{ ' - '. $user->mobile_two }}
                @endif
            </h6>
            <small>تاريخ الميلاد</small>
            <h6> {{ !is_null($user->date_of_birth) ? date('Y-m-d', strtotime($user->date_of_birth)) : '-' }}</h6>
            <small>رقم الهوية</small>
            <h6>{{ !is_null($user->id_number) ? $user->id_number : '-' }}</h6>
            <small>الحالة الاجتماعية</small>
            <h6>   {{ isset($user->social_status) ? $user->social_status->name : '-' }}</h6>
            <small>العنوان</small>
            <h6>
                {{ isset($user->governorate) ? $user->governorate->name .' - ' : '-' }}
                {{ isset($user->neighborhood) ? $user->neighborhood->name .' - ' : '-' }}
                {{ $user->address }}
            </h6>
            <small>تاريخ مباشرة العمل</small>
            <h6>    {{ !is_null($user->work_start_date) ? date('Y-m-d', strtotime($user->work_start_date)) : '-'}}</h6>
            <br>
        </div>
    </div>
</div>