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
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            @can('is-super-admin')
                                <th style="text-align: center">Action</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = ($admins->currentPage() - 1) * $admins->perPage();
                            ?>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ ++$count }}</td>
                                <td class="imgproduct-admin-cus"><img style="width: 100%; height: 100%;"
                                                                      src="{{ $admin->avatar }}" alt=""></td>
                                <td>{{ $admin->username }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->phone_number }}</td>
                                <td>{{ $admin->role == 0 ? 'Admin' : 'Super admin' }}</td>
                                <td>{{ $admin->lock == 0 ? 'Unlock' : 'Locked' }}</td>
                                @can('is-super-admin')
                                    <td style="text-align: center">
                                        <span>
                                            <a href="{{ route('admin.edit', ['id' => $admin->id]) }}"><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </a>
                                        </span>
                                        <span>
                                            <form id="form-delete-product" action="" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn-delete-user" style="cursor: pointer"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </form>
                                        </span>
                                        <span>
                                            <form action="{{ route('admin.change_status') }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="id" value="{{ $admin->id }}">
                                                <a class="btn-change-status-user" style="cursor: pointer"> @if ($admin->lock == 0) <i class="fa fa-lock" aria-hidden="true"></i> @else <i class="fa fa-unlock" aria-hidden="true"></i> @endif
                                                </a>
                                            </form>
                                        </span>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $admins->links('admin.layouts.pagination') }}
            </div>
        </div>
    </div>
@endsection
