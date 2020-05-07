<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
         data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            @if(auth()->user())
                <?php
                $links = auth()->user()->getAllPermissions()->where('in_setting', 0)->where('in_menu', 1)->where('parent_id', 0);
                ?>
                @foreach($links as $link)
                    <?php
                    $sub_links = auth()->user()->getAllPermissions()->where('in_menu', 1)->where('parent_id', $link->id);
                    $preventeroor = auth()->user()->getAllPermissions()->where('parent_id', $link->id);
                    ?>

                    <li class="kt-menu__item  kt-menu__item--submenu {{ strstr("/".Route::getFacadeRoot()->current()->uri(),$preventeroor->first()?$preventeroor->first()->link:"")? "kt-menu__item--open":'' }} "
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="24px" height="24px" viewBox="0 0 24 24"
                             version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"/>
                                <rect id="Rectangle-7" fill="#000000" x="4" y="4" width="7"
                                      height="7" rx="1.5"/>
                                <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                      id="Combined-Shape" fill="#000000" opacity="0.3"/>
                            </g>
                        </svg>
                    </span>
                            <span class="kt-menu__link-text">{{$link->title}}</span>
                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="kt-menu__submenu ">
                            <span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                            <span class="kt-menu__link">
                                <span class="kt-menu__link-text">{{$link->title}}</span>
                            </span>
                                </li>
                                @foreach($sub_links as $sub_link)
                                    <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true"
                                        data-ktmenu-submenu-toggle="hover">
                                        <a href="{{$sub_link->link}}" class="kt-menu__link kt-menu__toggle">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i>
                                            <span class="kt-menu__link-text">{{$sub_link->title}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endforeach


                @if(auth()->user()->getAllPermissions()->where('in_setting', 2)->where('in_menu', 1)->first())
                    <?php
                    $links = auth()->user()->getAllPermissions()->where('in_setting', 2)->where('in_menu', 1)->where('parent_id', 0);
                    ?>
                    <li class="kt-menu__item  kt-menu__item--submenu
                    {{ in_array( ('/'.rtrim(preg_replace('/[0-9]+\//', '', request()->path()), "/") ), auth()->user()->getAllPermissions()->where("in_menu", 1)->whereIn("parent_id", $links->pluck('id'))->pluck('link')->toArray())? "kt-menu__item--open":'' }}
                    {{ in_array( ('/'.rtrim(preg_replace('/[0-9]+/', '', request()->path()), "/") ), auth()->user()->getAllPermissions()->where("in_menu", 1)->whereIn("parent_id", $links->pluck('id'))->pluck('link')->toArray())? "kt-menu__item--open":'' }}
                    {{ in_array("/".Route::getFacadeRoot()->current()->uri(), auth()->user()->getAllPermissions()->where("in_menu", 1)->whereIn("parent_id", $links->pluck('id'))->pluck('link')->toArray())? "kt-menu__item--open":'' }}"
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="24px" height="24px" viewBox="0 0 24 24"
                             version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"/>
                                <rect id="Rectangle-7" fill="#000000" x="4" y="4" width="7"
                                      height="7" rx="1.5"/>
                                <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                      id="Combined-Shape" fill="#000000" opacity="0.3"/>
                            </g>
                        </svg>
                    </span>
                            <span class="kt-menu__link-text">الفعاليات</span>
                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                        </a>

                        <div class="kt-menu__submenu ">
                            <span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                            <span class="kt-menu__link">
                                <span class="kt-menu__link-text">الفعاليات</span>
                            </span>
                                </li>
                                @foreach($links as $link)
                                    <?php
                                    $sub_links = auth()->user()->getAllPermissions()->where('in_menu', 1)->where('parent_id', $link->id);
                                    $preventeroor = auth()->user()->getAllPermissions()->where('parent_id', $link->id);
                                    ?>

                                    <li class="kt-menu__item  kt-menu__item--submenu {{ strstr("/".Route::getFacadeRoot()->current()->uri(),$preventeroor->first()?$preventeroor->first()->link:"")? "kt-menu__item--open":'' }} "
                                        aria-haspopup="true"
                                        data-ktmenu-submenu-toggle="hover">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i>
                                            <span class="kt-menu__link-text">{{$link->title}}</span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="kt-menu__submenu ">
                                            <span class="kt-menu__arrow"></span>
                                            <ul class="kt-menu__subnav">
                                                @foreach($sub_links as $sub_link)
                                                    <li class="kt-menu__item " aria-haspopup="true">
                                                        <a href="{{$sub_link->link}}" class="kt-menu__link ">
                                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                                            <span class="kt-menu__link-text">{{$sub_link->title}}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                    </li>

                @endif

                @if(auth()->user()->getAllPermissions()->where('in_setting', 3)->where('in_menu', 1)->first())
                    <?php
                    $links = auth()->user()->getAllPermissions()->where('in_setting', 3)->where('in_menu', 1)->where('parent_id', 0);
                    ?>
                    <li class="kt-menu__item  kt-menu__item--submenu
                    {{ in_array(('/'.rtrim(preg_replace('/[0-9]+\//', '', request()->path()), "/") ), auth()->user()->getAllPermissions()->whereIn("parent_id", $links->pluck('id'))->pluck('link')->toArray())? "kt-menu__item--open":'' }}

                    {{ in_array(('/'.rtrim(preg_replace('/[0-9]+/', '', request()->path()), "/") ), auth()->user()->getAllPermissions()->whereIn("parent_id", $links->pluck('id'))->pluck('link')->toArray())? "kt-menu__item--open":'' }}

                    {{ in_array("/".Route::getFacadeRoot()->current()->uri(), auth()->user()->getAllPermissions()->whereIn("parent_id", $links->pluck('id'))->pluck('link')->toArray())? "kt-menu__item--open":'' }}
                            "
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="24px" height="24px" viewBox="0 0 24 24"
                             version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"/>
                                <rect id="Rectangle-7" fill="#000000" x="4" y="4" width="7"
                                      height="7" rx="1.5"/>
                                <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                      id="Combined-Shape" fill="#000000" opacity="0.3"/>
                            </g>
                        </svg>
                    </span>
                            <span class="kt-menu__link-text">إدارة النظام</span>
                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="kt-menu__submenu ">
                            <span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item  kt-menu__item--parent  test"
                                    aria-haspopup="true">
                            <span class="kt-menu__link">
                                <span class="kt-menu__link-text">إدارة النظام</span>
                            </span>
                                </li>
                                @foreach($links as $link)
                                    <?php
                                    $sub_links = auth()->user()->getAllPermissions()->where('in_menu', 1)->where('parent_id', $link->id);
                                    $preventeroor = auth()->user()->getAllPermissions()->where('parent_id', $link->id);
                                    ?>

                                    <li class="kt-menu__item  kt-menu__item--submenu {{ strstr("/".Route::getFacadeRoot()->current()->uri(),$preventeroor->first()?$preventeroor->first()->link:"")? "kt-menu__item--open":'' }} "
                                        aria-haspopup="true"
                                        data-ktmenu-submenu-toggle="hover">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i>
                                            <span class="kt-menu__link-text">{{$link->title}}</span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="kt-menu__submenu ">
                                            <span class="kt-menu__arrow"></span>
                                            <ul class="kt-menu__subnav">
                                                @foreach($sub_links as $sub_link)
                                                    <li class="kt-menu__item " aria-haspopup="true">
                                                        <a href="{{$sub_link->link}}" class="kt-menu__link ">
                                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                                            <span class="kt-menu__link-text">{{$sub_link->title}}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                    </li>

                @endif


                @if(auth()->user()->getAllPermissions()->where('in_setting', 1)->where('in_menu', 1)->first())
                    <?php
                    $links = auth()->user()->getAllPermissions()->where('in_setting', 1)->where('in_menu', 1)->where('parent_id', 0)->sortBy('title');
                    ?>
                    <li class="kt-menu__item  kt-menu__item--submenu
                    {{ in_array(('/'.rtrim(preg_replace('/[0-9]+\//', '', request()->path()), "/") ), auth()->user()->getAllPermissions()->where("in_menu", 1)->whereIn("parent_id", $links->pluck('id'))->pluck('link')->toArray())? "kt-menu__item--open":'' }}
                    {{ in_array(('/'.rtrim(preg_replace('/[0-9]+/', '', request()->path()), "/") ), auth()->user()->getAllPermissions()->where("in_menu", 1)->whereIn("parent_id", $links->pluck('id'))->pluck('link')->toArray())? "kt-menu__item--open":'' }}
                    {{ in_array("/".Route::getFacadeRoot()->current()->uri(), auth()->user()->getAllPermissions()->where("in_menu", 1)->whereIn("parent_id", $links->pluck('id'))->pluck('link')->toArray())? "kt-menu__item--open":'' }}"
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="24px" height="24px" viewBox="0 0 24 24"
                             version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"/>
                                <rect id="Rectangle-7" fill="#000000" x="4" y="4" width="7"
                                      height="7" rx="1.5"/>
                                <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                      id="Combined-Shape" fill="#000000" opacity="0.3"/>
                            </g>
                        </svg>
                    </span>
                            <span class="kt-menu__link-text">إدارة القوائم</span>
                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                        </a>

                        <div class="kt-menu__submenu ">
                            <span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                            <span class="kt-menu__link">
                                <span class="kt-menu__link-text">إدارة القوائم</span>
                            </span>
                                </li>
                                @foreach($links as $link)
                                    <?php
                                    $sub_links = auth()->user()->getAllPermissions()->where('in_menu', 1)->where('parent_id', $link->id);
                                    $preventeroor = auth()->user()->getAllPermissions()->where('parent_id', $link->id);
                                    ?>

                                    <li class="kt-menu__item  kt-menu__item--submenu {{ strstr("/".Route::getFacadeRoot()->current()->uri(),$preventeroor->first()?$preventeroor->first()->link:"")? "kt-menu__item--open":'' }} "
                                        aria-haspopup="true"
                                        data-ktmenu-submenu-toggle="hover">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i>
                                            <span class="kt-menu__link-text">{{$link->title}}</span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="kt-menu__submenu ">
                                            <span class="kt-menu__arrow"></span>
                                            <ul class="kt-menu__subnav">
                                                @foreach($sub_links as $sub_link)
                                                    <li class="kt-menu__item " aria-haspopup="true">
                                                        <a href="{{$sub_link->link}}" class="kt-menu__link ">
                                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                                            <span class="kt-menu__link-text">{{$sub_link->title}}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                    </li>

                @endif
            @endif


        </ul>
    </div>
</div>
