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
                <a class="nav-link {{ request()->routeIs(['admin.partners.*', 'admin.testimonials.*', 'admin.privacy.policy', 'admin.term.business']) ? '' : 'collapsed' }}"
                    href="javascript:;" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    CMS Management
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs(['admin.partners.*', 'admin.testimonials.*', 'admin.privacy.policy', 'admin.term.business', 'admin.our.story', 'admin.guided.journey', 'admin.protect', 'admin.witnesses']) ? 'show' : '' }}"
                    id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs(['admin.partners.*']) ? 'active' : '' }}"
                            href="{{ route('admin.partners.index') }}">Partners List</a>
                        <a class="nav-link {{ request()->routeIs(['admin.testimonials.*']) ? 'active' : '' }}"
                            href="{{ route('admin.testimonials.index') }}">Testimonials</a>
                        <a class="nav-link {{ request()->routeIs(['admin.our.story']) ? 'active' : '' }}"
                            href="{{ route('admin.our.story') }}">Our Story</a>
                        <a class="nav-link {{ request()->routeIs(['admin.guided.journey']) ? 'active' : '' }}"
                            href="{{ route('admin.guided.journey') }}">Guided Journey</a>
                        <a class="nav-link {{ request()->routeIs(['admin.protect']) ? 'active' : '' }}"
                            href="{{ route('admin.protect') }}">Protection</a>
                        <a class="nav-link {{ request()->routeIs(['admin.witnesses']) ? 'active' : '' }}"
                            href="{{ route('admin.witnesses') }}">Witnesses</a>
                        <a class="nav-link {{ request()->routeIs(['admin.privacy.policy']) ? 'active' : '' }}"
                            href="{{ route('admin.privacy.policy') }}">Privacy Policy</a>
                        <a class="nav-link {{ request()->routeIs(['admin.term.business']) ? 'active' : '' }}"
                            href="{{ route('admin.term.business') }}">Terms Of Business</a>
                    </nav>
                </div>

                <!-- Topics and Insights -->
                <a class="nav-link {{ request()->routeIs(['admin.topics.*', 'admin.case-studies.*']) ? '' : 'collapsed' }}"
                    href="javascript:;" data-bs-toggle="collapse" data-bs-target="#topicsAndInsights"
                    aria-expanded="false" aria-controls="topicsAndInsights">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Insights/Case Study
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs(['admin.topics.*', 'admin.case-studies.*']) ? 'show' : '' }}"
                    id="topicsAndInsights" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs(['admin.topics.*']) ? 'active' : '' }}"
                            href="{{ route('admin.topics.index') }}">Category</a>
                        <a class="nav-link {{ request()->routeIs(['admin.case-studies.*']) ? 'active' : '' }}"
                            href="{{ route('admin.case-studies.index') }}">Case Study</a>
                    </nav>
                </div>

                <!-- Pricing and Category -->
                <a class="nav-link {{ request()->routeIs(['admin.price-categories.*', 'admin.pricings.*', 'admin.packages.*']) ? '' : 'collapsed' }}"
                    href="javascript:;" data-bs-toggle="collapse" data-bs-target="#pricingAndCategory"
                    aria-expanded="false" aria-controls="pricingAndCategory">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Pricing
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs(['admin.price-categories.*', 'admin.pricings.*']) ? 'show' : '' }}"
                    id="pricingAndCategory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs(['admin.price-categories.*']) ? 'active' : '' }}"
                            href="{{ route('admin.price-categories.index') }}">Category</a>
                        <a class="nav-link {{ request()->routeIs(['admin.pricings.*']) ? 'active' : '' }}"
                            href="{{ route('admin.pricings.index') }}"> Pricing</a>
                        <a class="nav-link {{ request()->routeIs(['admin.packages.*']) ? 'active' : '' }}"
                            href="{{ route('admin.packages.index') }}"> Packages</a>
                    </nav>
                </div>

                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                    aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Authentication
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="login.html">Login</a>
                                <a class="nav-link" href="register.html">Register</a>
                                <a class="nav-link" href="password.html">Forgot Password</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#pagesCollapseError" aria-expanded="false"
                            aria-controls="pagesCollapseError">
                            Error
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="401.html">401 Page</a>
                                <a class="nav-link" href="404.html">404 Page</a>
                                <a class="nav-link" href="500.html">500 Page</a>
                            </nav>
                        </div>
                    </nav>
                </div> --}}

                <!-- Services -->
                <a class="nav-link {{ request()->routeIs(['admin.services.*']) ? 'active' : '' }} "
                    href="{{ route('admin.services.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Services
                </a>

                <!-- Wills -->
                <a class="nav-link {{ request()->routeIs(['admin.wills.list']) ? 'active' : '' }} "
                    href="{{ route('admin.wills.list') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Wills Requests
                </a>
                <!-- Contact Forms -->
                <a class="nav-link {{ request()->routeIs(['admin.contact.request']) ? 'active' : '' }}"
                    href="{{ route('admin.contact.request') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Contact Forms
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
