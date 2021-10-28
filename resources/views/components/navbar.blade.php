<!-- Order your soul. Reduce your wants. - Augustine -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" id="navbar">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="#" role="button">
                @auth('web')
                    @if (Cache::has('user-is-online-' . auth()->user()->id))
                        <i class="fas fa-circle text-green-700 text-sm" title="Online"></i>
                    @else
                        <i class="fas fa-circle text-red-600 text-sm" title="Offline"></i>
                    @endif
                @else
                    @if (Cache::has('teacher-is-online-' . auth()->user()->id))
                        <i class="fas fa-circle text-green-700 text-sm" title="Online"></i>
                    @else
                        <i class="fas fa-circle text-red-600 text-sm" title="Offline"></i>
                    @endif
                @endauth
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Go Fullscreen">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" role="button" id="dark-mode" title="Toggle dark mode">
            </a>
        </li>
    </ul>
</nav>
