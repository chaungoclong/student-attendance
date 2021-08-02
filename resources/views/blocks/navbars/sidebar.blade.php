<div class="sidebar" data-active-color="rose" data-background-color="white" data-image="{{ asset('assets/img/sidebar-1.jpg') }}">
            <!--
        Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
        Tip 2: you can also add an image using data-image tag
        Tip 3: you can change the color of the sidebar with data-background-color="white | black"
    -->
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="{{ asset('assets/img/faces/avatar.jpg') }}" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                        @if (Auth::check())
                            {{ Auth::user()->name }}
                        @endif
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('profile.show') }}">
                                <span class="sidebar-mini"> MP </span>
                                <span class="sidebar-normal"> My Profile </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <span class="sidebar-mini">
                                    <i class="fas fa-sign-out-alt"></i>
                                </span>
                                <span class="sidebar-normal"> Logout </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            {{-- function of admin --}}
            @auth('admin')
                {{-- dashboard --}}
                <li class="{{ request()->is('admin') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="material-icons">dashboard</i>
                        <p> Dashboard </p>
                    </a>
                </li>

                {{-- admin --}}
                @can('admin-manager')
                    <li class="{{  request()->is('admin/admin-manager')
                        || request()->is('admin/admin-manager/*') 
                        ? 'active' : ''  }}">
                        <a href="{{ route('admin.admin-manager.index') }}">
                            <i class="material-icons">image</i>
                            <p> 
                                Quản lý Giáo vụ
                            </p>
                        </a>
                    </li>
                @endcan

                {{-- teacher --}}
                <li class="{{ 
                    request()->is('admin/teacher-manager')
                    || request()->is('admin/teacher-manager/*') 
                    ? 'active' : '' 
                }}">
                    <a href="{{ route('admin.teacher-manager.index') }}">
                        <i class="material-icons">image</i>
                        <p> 
                            Quản lý Giáo viên
                        </p>
                    </a>
                </li>

                {{-- assign --}}
                <li class="{{ request()->is('admin/assign') || request()->is('admin/assign/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.assign.index') }}">
                        <i class="material-icons">image</i>
                        <p> 
                            Phân công giảng dạy
                        </p>
                    </a>
                </li>

                {{-- lession --}}
                <li>
                    <a href="{{ route('admin.lesson.index') }}">
                        <i class="material-icons">image</i>
                        <p> 
                            Quản lý ca học
                        </p>
                    </a>
                </li>

                {{-- schedule --}}
                <li>
                    <a>
                        <i class="material-icons">image</i>
                        <p> 
                            Quản lý Lịch học
                        </p>
                    </a>
                </li>

                {{-- year schools --}}
                <li>
                    <a href="{{ route('admin.yearschool.index') }}">
                        <i class="material-icons">image</i>
                        <p> 
                            Quản lý Khóa học
                        </p>
                    </a>
                </li>

                {{-- grade --}}
                <li>
                    <a href="{{ route('admin.grade.index') }}">
                        <i class="material-icons">image</i>
                        <p> 
                            Quản lý Lớp học
                        </p>
                    </a>
                </li>

                {{-- subject --}}
                <li>
                    <a href="{{ route('admin.subject.index') }}">
                        <i class="material-icons">image</i>
                        <p> 
                            Quản lý môn học
                        </p>
                    </a>
                </li>

                {{-- student --}}
                <li class="{{  request()->is('admin/student-manager')
                    || request()->is('admin/student-manager/*') 
                    ? 'active' : ''  }}">
                    <a href="{{ route('admin.student-manager.index') }}">
                        <i class="material-icons">image</i>
                        <p> 
                            Quản lý Sinh viên
                        </p>
                    </a>
                </li>

                {{-- class room --}}
                <li>
                    <a href="{{ route('admin.classroom.index') }}">
                        <i class="material-icons">house</i>
                        <p> 
                            Quản lý phòng học
                        </p>
                    </a>
                </li>

                {{-- statistical --}}
                <li>
                    <a>
                        <i class="material-icons">image</i>
                        <p> 
                            Thống kê
                        </p>
                    </a>
                </li>
            @endauth

            {{-- function of teacher --}}
            @auth('teacher')
            {{-- dashboard --}}
            <li class="{{ request()->is('teacher') ? 'active' : '' }}">
                <a href="{{ route('teacher.dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                </a>
            </li>

            {{-- attendance --}}
           <li>
                <a data-toggle="collapse" href="#attendance">
                    <i class="material-icons">image</i>
                    <p> Điểm danh
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="attendance">
                    <ul class="nav">
                        <li class="{{ request()->is('teacher/attendance/create') ? 'active' : '' }}">
                            <a href="{{ route('teacher.attendance.create') }}">
                                <span class="sidebar-mini"> P </span>
                                <span class="sidebar-normal"> Tạo điểm danh </span>
                            </a>
                        </li>
                        <li>
                            <a href="./pages/rtl.html">
                                <span class="sidebar-mini"> RS </span>
                                <span class="sidebar-normal"> Xem điểm danh </span>
                            </a>
                        </li>
                        <li>
                            <a href="./pages/timeline.html">
                                <span class="sidebar-mini"> T </span>
                                <span class="sidebar-normal"> Tạo báo cáo </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Work --}}
            <li>
                <a data-toggle="collapse" href="#assignMenu">
                    <i class="material-icons">image</i>
                    <p> Công việc
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="assignMenu">
                    <ul class="nav">
                        <li>
                            <a href="./pages/pricing.html">
                                <span class="sidebar-mini"> P </span>
                                <span class="sidebar-normal"> 
                                  Phân công
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="./pages/pricing.html">
                                <span class="sidebar-mini"> P </span>
                                <span class="sidebar-normal"> 
                                  Lịch dạy
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- report --}}
            <li>
                <a>
                    <i class="material-icons">image</i>
                    <p> 
                        Báo cáo
                    </p>
                </a>
            </li>
            @endauth

            {{-- common function --}}
            {{-- email --}}
            <li>
                <a>
                    <i class="material-icons">image</i>
                    <p> 
                        Email
                    </p>
                </a>
            </li>
        </ul>
    </div>
</div>