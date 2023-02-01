@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div class="row">
            {{-- @dd($productsInStock->perPage()) --}}
            <div id="" class="tab-pane fade in active">
                <div style="margin-top: 20px">
                    <table class="table table-hover table-admin-cus">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Website</th>
                            <th>Amount Product</th>
                            <th>UserId</th>
                            <th>AddressId</th>
                            @canany(['edit_shop', 'delete_shop'])
                                <th style="text-align: center">Action</th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = ($shops->currentPage() - 1) * $shops->perPage();
                        ?>
                        @foreach ($shops as $shop)
                            <tr>
                                <td>{{ ++$count }}</td>
                                <td class="imgproduct-admin-cus"><img style="width: 100%; height: 100%;"
                                                                      src="{{ $shop['img_shop'] }}" alt=""></td>
                                <td>{{ $shop['name'] }}</td>
                                <td><a href="{{ $shop['web_site'] }}">Link</a></td>
                                <td>{{ $shop->products->count() }}</td>
                                <td>{{ $shop->user_id }}</td>
                                <td>{{ $shop->address_id }}</td>
                                @canany(['edit_shop', 'delete_shop'])
                                    <td style="text-align: center">
                                        @can('edit_shop')
                                            <span>
                                                <a href="{{ route('admin.shop.edit', ['id' => $shop->id]) }}"><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                        @endcan
                                        @can('delete_shop')
                                            <span>
                                                <form id="form-delete-product" action="" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="btn-delete-product-instock"><i class="fa fa-trash-o"
                                                                                             aria-hidden="true"></i>
                                                    </a>
                                                </form>
                                            </span>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $shops->links('admin.layouts.pagination') }}
            </div>
        </div>
    </div>
@endsection
