<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                {{-- <div class="sb-sidenav-menu-heading">Core</div> --}}
                <a class="nav-link {{ request()->routeIs(['admin.dashboard']) ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <!-- Cms Management -->
                {{-- <a class="nav-link {{ request()->routeIs(['admin.partners.*', 'admin.testimonials.*', 'admin.privacy.policy', 'admin.term.business']) ? '' : 'collapsed' }}"
                    href="javascript:;" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    CMS Management
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs(['admin.home-page-setting.*']) ? 'show' : '' }}"
                    id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs(['admin.home-page-setting.*']) ? 'active' : '' }}"
                            href="{{ route('admin.home-page-setting.index') }}">Home Page</a>
                    </nav>
                </div> --}}

                <!-- Setting -->
                <a class="nav-link {{ request()->routeIs(['admin.all-page']) ? 'active' : '' }} "
                    href="{{ route('admin.all-page') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    All Pages
                </a>

                <!-- Setting -->
                <a class="nav-link {{ request()->routeIs(['admin.site.setting']) ? 'active' : '' }} "
                    href="{{ route('admin.site.setting') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                    Settings
                </a>
            </div>
        </div>

        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:
                <span style="float: right">

                    <i class="fas fa-sign-out-alt"
                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"
                        style="cursor: pointer;font-size:26px;"></i>
                    <a href="{{ route('admin.site.setting') }}"> <i style="font-size:24px; float: right;"
                            class="fa mx-2">&#xf013;</i></a>
                </span>

                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{-- {{ __('Logout') }} --}}
                </a>

                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </div>
            <h5>{{ Auth::user()->name ?? '' }}</h5>
        </div>
    </nav>
</div>
