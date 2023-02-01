<header>
    <div class="header-middle">
        <!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="{{ route('index') }}"><img src="{{ asset('images/home/logo.png') }}" alt=""/></a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            @if (!auth()->check())
                                <li><a href="{{ route('login') }}"><i class="fa fa-lock"></i> Login</a></li>
                            @else
                                <li>
                                    <a href="">
                                        <div class="account-home">
                                            <div class="avata-img-home">
                                                <img src="{{ auth()->user()->avatar }}" alt=""
                                                     style="width: 100%;height: 100%;">
                                            </div>
                                            <span>{{ auth()->user()->name }}</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="logout-header">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
