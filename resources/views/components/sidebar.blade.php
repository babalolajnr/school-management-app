   <!-- Well begun is half done. - Aristotle -->
   <aside class="main-sidebar main-sidebar-custom  elevation-4" id="sidebar">
       <!-- Brand Logo -->
       <a href="/dashboard" class="brand-link d-flex justify-content-center" id="brand-link">
           <img src="{{ asset('images/radiant_logo-removebg-preview.png') }}" alt="Logo"
               class="brand-image img-circle elevation-3" style="opacity: .8"><span
               class="brand-text font-weight-light">Radiant Minds School</span>
       </a>

       <!-- Sidebar -->
       <div class="sidebar">
           <!-- Sidebar user (optional) -->
           <div class="user-panel mt-3 pb-3 mb-3 d-flex">
               <div class="image">
                   <img src="https://img.icons8.com/plumpy/192/000000/user.png" class="img-circle elevation-2"
                       alt="User Image">
               </div>
               <div class="info">
                   @if (Auth::guard('web')->user())
                       <a href="{{ route('user.show', ['user' => Auth::user()]) }}" class="d-block">
                           {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
                   @else
                       <a href="{{ route('teacher.show', ['teacher' => Auth::guard('teacher')->user()]) }}"
                           class="d-block">{{ Auth::guard('teacher')->user()->last_name }}
                           {{ Auth::guard('teacher')->user()->last_name }}</a>
                   @endif
               </div>
           </div>

           <!-- SidebarSearch Form -->
           <div class="form-inline">
               <div class="input-group" data-widget="sidebar-search">
                   <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                       aria-label="Search">
                   <div class="input-group-append">
                       <button class="btn btn-sidebar">
                           <i class="fas fa-search fa-fw"></i>
                       </button>
                   </div>
               </div>
           </div>

           <!-- Sidebar Menu -->
           <nav class="mt-2">
               <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                   data-accordion="false">
                   <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                   @if (Auth::guard('web')->user())
                       <li class="nav-item">
                           <a href="{{ route('dashboard') }}" class="nav-link" id="dashboard">
                               <i class="nav-icon fas fa-tachometer-alt"></i>
                               <p>
                                   Dashboard
                               </p>
                           </a>
                       </li>
                       <li class="nav-item menu-is-opening menu-open">
                           <a href="#" class="nav-link" id="school-management">
                               <i class="nav-icon fas fa-school"></i>
                               <p>
                                   School Management
                                   <i class="fas fa-angle-left right"></i>
                               </p>
                           </a>
                           <ul class="nav nav-treeview" style="display: block;">
                               <li class="nav-item">
                                   <a href="{{ route('academic-session.index') }}" class="nav-link"
                                       id="academic-session">
                                       <i class="nav-icon fas fa-calendar"></i>
                                       <p>Academic Sessions</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('period.index') }}" class="nav-link" id="period">
                                       <i class="nav-icon fas fa-hourglass-half"></i>
                                       <p>Periods</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('fee.index') }}" class="nav-link" id="fee">
                                       <i class="nav-icon fas fa-money-bill-wave"></i>
                                       <p>Fees</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('classroom.index') }}" class="nav-link" id="classroom">
                                       <i class="nav-icon fas fa-chalkboard"></i>
                                       <p>Classrooms</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('term.index') }}" class="nav-link" id="term">
                                       <i class="nav-icon fas fa-clock"></i>
                                       <p>Terms</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('subject.index') }}" class="nav-link" id="subject">
                                       <i class="nav-icon fas fa-book"></i>
                                       <p>Subjects</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('teacher.index') }}" class="nav-link" id="teacher">
                                       <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                       <p>Teachers</p>
                                   </a>
                               </li>
                           </ul>
                       </li>
                       <li class="nav-item menu-is-opening menu-open">
                           <a href="#" class="nav-link" id="student-management">
                               <i class="nav-icon fa fa-child"></i>

                               <p>
                                   Students Management
                                   <i class="fas fa-angle-left right"></i>
                               </p>
                           </a>
                           <ul class="nav nav-treeview" style="display: block;">
                               <li class="nav-item">
                                   <a href="{{ route('student.index') }}" class="nav-link" id="student-index">
                                       <i class="nav-icon fas fa-user-graduate"></i>
                                       <p>Students</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('student.create') }}" class="nav-link"
                                       id="student-create">
                                       <i class="fas fa-user-plus"></i>
                                       <p>New Student</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('student.get.alumni') }}" class="nav-link"
                                       id="student-get-alumni">
                                       <span class="nav-icon"><i class="fas fa-graduation-cap"></i></span>
                                       <p>Alumni</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('student.get.inactive') }}" class="nav-link"
                                       id="student-get-inactive">
                                       <span class="nav-icon"><i class="fas fa-ban"></i></span>
                                       <p>Inactive Students</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('pd-type.index') }}" class="nav-link" id="pd-type">
                                       <i class="nav-icon fas fa-biking"></i>
                                       <p>Pychomotor domains</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('ad-type.index') }}" class="nav-link" id="ad-type">
                                       <i class="nav-icon fas fa-brain"></i>
                                       <p>Affective domains</p>
                                   </a>
                               </li>

                           </ul>
                       </li>
                       @masteruser (Auth::user())
                       <li class="nav-item menu-is-opening menu-open">
                           <a href="#" class="nav-link" id="app-management">
                               <i class="nav-icon fas fa-cog"></i>
                               <p>
                                   App Management
                                   <i class="fas fa-angle-left right"></i>
                               </p>
                           </a>
                           <ul class="nav nav-treeview" style="display: block;">
                               <li class="nav-item">
                                   <a href="{{ route('user.index') }}" class="nav-link" id="user">
                                       <i class="nav-icon fas fa-users"></i>
                                       <p>Users</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('notification.index') }}" class="nav-link"
                                       id="notification">
                                       <i class="nav-icon fas fa-bell"></i>
                                       <p>Notifications</p>
                                   </a>
                               </li>
                           </ul>
                       </li>
                       @endmasteruser

                   @endif
                   @auth('teacher')
                       <li class="nav-item">
                           <a href="{{ route('classroom.show', ['classroom' => auth('teacher')->user()->classroom]) }}"
                               class="nav-link">
                               <i class="nav-icon fas fa-chalkboard"></i>
                               <p>Classroom</p>
                           </a>
                       </li>
                   @endauth
               </ul>
           </nav>
           <!-- /.sidebar-menu -->
       </div>
       <!-- /.sidebar -->

       <div class="sidebar-custom d-flex">
           <form @auth('web') action="{{ route('logout') }}" @endauth @auth('teacher')
           action="{{ route('teacher.logout') }}" @endauth method="post">
           @csrf
           <button type="submit" class="btn btn-link" title="Logout"><i
                   class="fas fa-sign-out-alt text-danger"></i></button>
       </form>
       <a href="#" class="btn btn-secondary hide-on-collapse pos-right">Help</a>
   </div>
   <!-- /.sidebar-custom -->
</aside>
