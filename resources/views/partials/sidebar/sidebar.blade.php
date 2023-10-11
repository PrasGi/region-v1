<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'dashboard' ? 'active' : '' }} collapsed"
                href="{{ route('dashboard') }}">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if (auth()->user()->role->name == 'admin')
            <li class="nav-heading">data</li>

            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'province.index' ? 'active' : '' }} collapsed"
                    href="{{ route('province.index') }}">
                    <i class="bi bi-flag"></i>
                    <span>Province</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'regency.index' ? 'active' : '' }} collapsed"
                    href="{{ route('regency.index') }}">
                    <i class="bi bi-bank"></i>
                    <span>Regency</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'district.index' ? 'active' : '' }} collapsed"
                    href="{{ route('district.index') }}">
                    <i class="bi bi-broadcast-pin"></i>
                    <span>District</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'village.index' ? 'active' : '' }} collapsed"
                    href="{{ route('village.index') }}">
                    <i class="bi bi-house"></i>
                    <span>Village</span>
                </a>
            </li>
        @endif
        <li class="nav-heading">authenticate</li>

        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'token.index' ? 'active' : '' }} collapsed"
                href="{{ route('token.index') }}">
                <i class="bi bi-key"></i>
                <span>Token</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->
