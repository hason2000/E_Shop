<div class="col-md-3 left_col" style="margin-top: 10px">
    <div class="left_col scroll-view">
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li><a href="{{ route('admin.index') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                    </li>
                    <li><a><i class="fa fa-product-hunt" aria-hidden="true"></i> Products <span
                                class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin.product.in_stock') }}">In stock</a></li>
                            <li><a href="{{ route('admin.product.out_stock') }}">Out stock</a></li>
                            @can('create_product')
                                <li><a href="{{ route('admin.product.create') }}">Create</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li><a><i class="fa fa-shopping-bag" aria-hidden="true"></i> Shops <span
                                class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin.shops.index') }}">View</a></li>
                            @can('create_shop')
                                <li><a href="#">Create</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i></i> Order</a>
                    </li>
                    <li><a><i class="fa fa-users" aria-hidden="true"></i> Users <span
                                class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin.user.index') }}">View</a></li>
                            @can('create_user')
                                <li><a href="#">Create</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li><a><i class="fa fa-address-book" aria-hidden="true"></i> Admins <span
                                class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin.show_all') }}">View</a></li>
                            @canany(['super_admin', 'create_admin'])
                                <li><a href="#">Create</a></li>
                            @endcan
                        </ul>
                    </li>
{{--                    @can('super_admin')--}}
                        <li><a><i class="fa fa-bars" aria-hidden="true"></i> Roles&Permission <span
                                    class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{ route('admin.role.index') }}">Role</a></li>
                                <li><a href="{{ route('admin.permission.index') }}">Permission</a></li>
                                <li><a href="{{ route('admin.role.show_authorize') }}">Authorize Role</a></li>
                                <li><a href="{{ route('admin.authorize_admins') }}">Authorize Admin</a></li>
                                <li><a href="{{ route('admin.permission_admins') }}">Permission Admin</a></li>
                            </ul>
                        </li>
{{--                    @endcan--}}
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('admin.logout') }}">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
