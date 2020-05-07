<html dir="rtl">
<head>
    <meta http-equiv='Content-Type' charset='utf-8'/>
    <style type="text/css">
        *, body, table, th, tr, td, tbody {
            font-family: 'examplefont', sans-serif;
            text-align: right;

        }
    </style>
</head>
<body>
<div>
    <div>
        <div>
            <div>
                @for($i=0;$i<count($users);$i++)
                    <hr style="border: 3px black solid">
                    <div class="row">
                        <div class="card">
                            <div class="card-content">
                                <h5 class="card-title"> صلاحيات المستخدم
                                    (
                                    <span style="color: red"> {{ $users[$i]->first_name ?? "" }}{{" ".$users[$i]->family_name ?? "" }} </span>
                                    )
                                </h5>
                                <div class="row">
                                    @foreach($links[$i] as $link)
                                        <?php $sublinks = \Spatie\Permission\Models\Permission::where("parent_id", $link->id)->get(); ?>
                                        <div class="input-field col s12 m6 l6">
                                            <div class="input-field">
                                                @if($users[$i]->hasPermissionTo($link->id))<B>{{$link->title}}
                                                    | </B>@endif
                                                @foreach($sublinks as $sublink)
                                                    @if($users[$i]->hasPermissionTo($sublink->id))<span>{{$sublink->title}},</span>@endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    @if($users[$i]->hasAnyPermission($sitting_links[$i]->pluck('id')->toArray()))
                        <div class="row">
                            <div class="card">
                                <div class="card-content">
                                    <h5 class="card-title">صلاحيات القوائم المنسدلة </h5>
                                    <div class="row">
                                        @foreach($sitting_links[$i] as $link)
                                            <?php $sublinks = \Spatie\Permission\Models\Permission::where("parent_id", $link->id)->get(); ?>
                                            <div class="input-field col s12 m6 l6">
                                                <div class="input-field">
                                                    @if($users[$i]->hasPermissionTo($link->id))
                                                        <B>{{$link->title}} |</B> @endif
                                                    @foreach($sublinks as $sublink)
                                                        @if($users[$i]->hasPermissionTo($sublink->id)) <span>{{$sublink->title}} ,</span> @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
</div>
</body>
</html>

