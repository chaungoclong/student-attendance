<div class="sidebar" data-active-color="rose" data-background-color="black" data-image="{{ asset('assets/img/sidebar-1.jpg') }}">
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
                            <a href="#">
                                <span class="sidebar-mini"> MP </span>
                                <span class="sidebar-normal"> My Profile </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="sidebar-mini"> EP </span>
                                <span class="sidebar-normal"> Edit Profile </span>
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
            <li class="active">
                <a href="">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                </a>
            </li>

            {{-- function of admin --}}
            @auth('admin')
            {{-- admin --}}
            <li>
                <a>
                    <i class="material-icons">image</i>
                    <p> 
                        Quản lý Giáo vụ
                    </p>
                </a>
            </li>

            {{-- teacher --}}
            <li>
                <a>
                    <i class="material-icons">image</i>
                    <p> 
                        Quản lý Giáo viên
                    </p>
                </a>
            </li>

            {{-- assign --}}
            <li>
                <a>
                    <i class="material-icons">image</i>
                    <p> 
                        Phân công giảng dạy
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
                <a href="{{ route('yearschool.index') }}">
                    <i class="material-icons">image</i>
                    <p> 
                        Quản lý Khóa học
                    </p>
                </a>
            </li>

            {{-- grade --}}
            <li>
                <a href="{{ route('grade.index') }}">
                    <i class="material-icons">image</i>
                    <p> 
                        Quản lý Lớp học
                    </p>
                </a>
            </li>

            {{-- subject --}}
            <li>
                <a href="{{ route('subject.index') }}">
                    <i class="material-icons">image</i>
                    <p> 
                        Quản lý môn học
                    </p>
                </a>
            </li>

            {{-- student --}}
            <li>
                <a>
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
            {{-- attendance --}}
            <li>
                <a>
                    <i class="material-icons">image</i>
                    <p> 
                        Điểm danh
                    </p>
                </a>
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