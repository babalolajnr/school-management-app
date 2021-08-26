<!-- Order your soul. Reduce your wants. - Augustine -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
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
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                @if (Cache::has('user-is-online-' . auth()->user()->id))
                    <i class="fas fa-circle text-green-700 text-sm" title="Online"></i>
                @else
                    <i class="fas fa-circle text-red-600 text-sm" title="Offline"></i>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" role="button" id="dark-mode">
            </a>
        </li>
    </ul>
</nav>
