<div class="kt-header__topbar">
    <!--begin: Search -->
    <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown"
         id="kt_quick_search_toggle">
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px"
             aria-expanded="false">
								<span class="kt-header__topbar-icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                         class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24"></rect>
											<path
                                                    d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
											<path
                                                    d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                    fill="#000000" fill-rule="nonzero"></path>
										</g>
									</svg> </span>
        </div>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg"
             x-placement="bottom-end"
             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(44px, 64px, 0px);">
            <div class="kt-quick-search kt-quick-search--dropdown kt-quick-search--result-compact"
                 id="kt_quick_search_dropdown">
                <form method="get" id="search" action="/admin/search" class="kt-quick-search__form">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i
                                        class="flaticon2-search-1"></i></span></div>
                        <input type="text" name="q" class="form-control "
                               placeholder="البحث.." id="q">

                        <div class="input-group-append"><span class="input-group-text"><i
                                        class="la la-close kt-quick-search__close"></i></span></div>
                    </div>
                </form>
                <div class="kt-quick-search__wrapper kt-scroll ps" data-scroll="true"
                     data-height="325" data-mobile-height="200"
                     style="height: 325px; overflow: hidden;">
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end: Search -->

    <!--begin: ! -->
    <!--end: ! -->

    <!--begin: Notifications -->
    @if(auth()->user())
        <div class="kt-header__topbar-item dropdown">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px"
                 aria-expanded="true">
								<span class="kt-header__topbar-icon kt-pulse kt-pulse--brand">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                         class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24"/>
											<path
                                                    d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                    fill="#000000" opacity="0.3"/>
											<path
                                                    d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                    fill="#000000"/>
										</g>
									</svg>
									<span class="kt-pulse__ring"></span>
								</span>
                <?php

                $notifications = auth()->user()->unreadNotifications()->get()->sortByDesc('created_at');
                $count = count($notifications);
                ?>
                <span class="kt-header__topbar-icon kt-pulse kt-pulse--brand num_notif" style="margin-left: 20px;color: #ffffff;background-color: #6e7899;
								font-size: 20px;margin-right: 0px; width: 25px;height: 25px;">{{$count}}</span>
            </div>
            <div
                    class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg">
                <form>
                    <!--begin: Head -->
                    <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b"
                         style="background-image: url({{asset('new_theme/assets/media/misc/bg-1.jpg')}}" )>

                        <h3 class="kt-head__title">
                            تنبيهات المستخدم
                            &nbsp;
                            <span class="btn btn-success btn-sm btn-bold btn-font-md num_notif"> {{$count}} تتبيه </span>
                        </h3>
                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show"
                                   href="/admin/notifications"
                                >جميع التنبيهات</a>
                            </li>
                        </ul>
                    </div>
                    <!--end: Head -->

                    <div class="tab-content">
                        <div class="tab-pane active show" id="topbar_notifications_notifications"
                             role="tabpanel">
                            <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll"
                                 data-scroll="true" data-height="300" data-mobile-height="200" id="notif">
                                @foreach($notifications as $notification)
                                    <?php $action = $notification->data['action']; ?>

                                        <a href="{{$action['link']}}" the_href="{{$action['link']}}" class="kt-notification__item"
                                       onclick='pop(this)' the_id='{{$notification->id}}'>
                                        <div class="kt-notification__item-icon">
                                            {{$action['type']}}
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                {{$action['title']}}
                                            </div>
                                            <div class="kt-notification__item-time">
                                                {{date('d-m-Y', strtotime($action['created_at']))}}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                            <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                <div
                                        class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                    <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                        كل شيء على ما يرام!
                                        <br>لا يوجد اشعارات جديدة.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
<!--end: Notifications -->

    <!--begin: User Bar -->
    @if(auth()->user())
        @php $user = auth()->user();@endphp
        <div class="kt-header__topbar-item kt-header__topbar-item--user">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                <div class="kt-header__topbar-user">
                    <span class="kt-header__topbar-welcome kt-hidden-mobile">أهلا وسهلا بالموظف</span>
                    <span class="kt-header__topbar-username kt-hidden-mobile">{{ $user->full_name }}</span>
                    @if(((!is_null($user->image)) && (!is_null($user->image)) && (($user->image != ''))))
                        <img class="" alt="Pic" src="{{ asset($user->image) }}"/>
                    @else
                        <img class="" alt="Pic" src="{{asset('new_theme/assets/media/users/default.jpg')}}"/>
                    @endif
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
                <!--begin: Head -->
                <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                     style="background-image: url({{asset('new_theme/assets/media/misc/bg-1.jpg')}})">
                    <div class=" kt-user-card__avatar
                            ">
                        @if(((!is_null($user->image)) && (!is_null($user->image)) && (($user->image != ''))))

                            <img class="kt-hidden" alt="Pic"
                                 src="{{ asset($user->image) }}"/>
                        @else
                            <img class="kt-hidden" alt="Pic"
                                 src="{{asset('new_theme/assets/media/users/default.jpg')}}"/>
                        @endif
                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                        <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">
						 @if(((!is_null($user->image)) && (!is_null($user->image)) && (($user->image != ''))))
                                <img alt="Pic" src="{{ asset($user->image) }}"/></span>
                        @else
                            <img alt="Pic" src="{{asset('new_theme/assets/media/users/default.jpg')}}"/></span>

                        @endif
                    </div>
                    <div class="kt-user-card__name">{{ $user->user_name }}
                    </div>
                    @if(auth()->user()->tasks->first())
                        <div class="kt-user-card__badge">
                            <a href="/admin/profile/tasks">
                                <span class="btn btn-success btn-sm btn-bold btn-font-md">{{auth()->user()->tasks->count()}} مهام جديدة</span>
                            </a>
                        </div>
                    @endif
                </div>
                <!--end: Head -->

                <!--begin: Navigation -->
                <div class="kt-notification">
                    <a href="{{ url('admin/profile/edit') }}" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-calendar-3 kt-font-success"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title kt-font-bold">
                                الصفحة الشخصية
                            </div>
                        </div>
                    </a>
                    <a href="/admin/profile/tasks" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-mail kt-font-warning"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title kt-font-bold">
                                كل المهام
                            </div>
                        </div>
                    </a>
                    <div class="kt-notification__custom kt-space-between">
                        <a href="{{ route('logout') }}"
                           class="btn btn-label btn-label-brand btn-sm btn-bold">تسجيل خروج</a>
                        <a href="{{ url('admin/profile/edit') }}" target="_blank"
                           class="btn btn-clean btn-sm btn-bold">تغيير كلمة المرور</a>
                    </div>
                </div>
                <!--end: Navigation -->
            </div>
        </div>
@endif
<!--end: User Bar -->
</div>