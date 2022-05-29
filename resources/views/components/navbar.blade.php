<!-- Order your soul. Reduce your wants. - Augustine -->
<nav class="main-header navbar navbar-expand" id="navbar">
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
                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge badge-warning navbar-badge"
                        id="notifications-badge-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <span class="dropdown-item dropdown-header"><span
                        id="notifications-header-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                    Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach (auth()->user()->unreadNotifications as $notification)
                    <span
                        onclick="showNotification('{{ route('notification.read', ['notification' => $notification]) }}',{{ $notification }})"
                        class="dropdown-item" id="{{ $notification->id }}">
                        @if ($notification->type == 'App\Notifications\AppNotification')
                            <i class="far fa-bell mr-2"></i>
                        @endif
                        <span
                            class="float-right text-muted text-sm">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans() }}</span>
                        <span>
                            @if (strlen($notification->data['title']) > 16)
                                {{ substr($notification->data['title'], 0, 16) }}...
                            @else
                                {{ $notification->data['title'] }}
                            @endif
                        </span>
                    </span>
                    <div class="dropdown-divider"></div>
                @endforeach
                <a href="{{ route('notification.inbox') }}" class="dropdown-item dropdown-footer">See All
                    Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" role="button" id="dark-mode" title="Toggle dark mode">
            </a>
        </li>
    </ul>
</nav>
