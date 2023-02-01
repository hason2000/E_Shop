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
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>DOB</th>
                            <th>Phone</th>
                            <th>ShopId</th>
                            <th>Status Lock</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = ($users->currentPage() - 1) * $users->perPage();
                        ?>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ ++$count }}</td>
                                <td class="imgproduct-admin-cus"><img style="width: 100%; height: 100%;"
                                                                      src="{{ $user->avatar }}" alt=""></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->date_of_birth }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $user->shop ? $user->shop->id : 0 }}</td>
                                <td>{{ $user->lock == 0 ? 'Unlock' : 'Locked' }}</td>
                                <td style="text-align: center">
                                    <span>
                                        <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                    <span>
                                        <form id="form-delete-product" action="" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn-delete-product-instock"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </form>
                                    </span>
                                    <span>
                                        <form action="{{ route('admin.user.change_status', ['id' => $user->id]) }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <a class="btn-change-status-user" style="cursor: pointer"> @if ($user->lock == 0) <i class="fa fa-lock" aria-hidden="true"></i> @else <i class="fa fa-unlock" aria-hidden="true"></i> @endif
                                            </a>
                                        </form>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links('admin.layouts.pagination') }}
            </div>
        </div>
    </div>
@endsection
