<table class="table table-hover table-admin-cus">
    <thead>
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Brand</th>
        <th>Shop</th>
        <th>Price</th>
        <th style="text-align: center">Img</th>
        @canany(['edit_product', 'delete_product'])
            <th style="text-align: center">Action</th>
        @endcanany
    </tr>
    </thead>
    <tbody>
        <?php
        $count = ($productsOutStock->currentPage() - 1) * $productsOutStock->perPage();
        ?>
    @foreach ($productsOutStock as $product)
        <tr>
            <td>{{ ++$count }}</td>
            <td>{{ $product['name'] }}</td>
            <td>{{ $product->brand->name }}</td>
            <td>{{ $product->shop->name }}</td>
            <td>{{ $product->price }}$</td>
            <td class="imgproduct-admin-cus"><img style="width: 100%; height: 100%;"
                                                  src="{{ $product->img_link }}" alt=""></td>
            @canany(['edit_product', 'delete_product'])
                <td style="text-align: center">
                    @can('edit_product')
                        <span><a href="{{ route('admin.product.edit', ['id' => $product->id]) }}"><i
                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></a></span>
                    @endcan
                    @can('delete_product')
                        <span><a href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
                    @endcan
                </td>
            @endcanany
        </tr>
    @endforeach
    </tbody>
</table>
{{ $productsOutStock->links('admin.layouts.pagination') }}
