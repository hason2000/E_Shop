<?php

namespace App\Providers;

use App\Repositories\Address\AddressRepository;
use App\Repositories\Address\AddressRepositoryInterface;
use App\Repositories\Address\AddressShopRepository;
use App\Repositories\Address\AddressShopRepositoryInterface;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Img\ImgRepository;
use App\Repositories\Img\ImgRepositoryInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductSize\ProductSizeRepository;
use App\Repositories\ProductSize\ProductSizeRepositoryInterface;
use App\Repositories\Roles\RoleRepository;
use App\Repositories\Roles\RoleRepositoryInterface;
use App\Repositories\Shop\ShopRepository;
use App\Repositories\Shop\ShopRepositoryInterface;
use App\Repositories\Size\SizeRepository;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Laravel\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(ImgRepositoryInterface::class, ImgRepository::class);
        $this->app->bind(SizeRepositoryInterface::class, SizeRepository::class);
        $this->app->bind(ShopRepositoryInterface::class, ShopRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(AddressShopRepositoryInterface::class, AddressShopRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(ProductSizeRepositoryInterface::class, ProductSizeRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
