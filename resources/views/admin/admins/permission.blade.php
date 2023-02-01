@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div class="row">
            <div id="" class="tab-pane fade in active">
                <div style="margin-top: 20px">
                    <form action="{{ route('admin.update_permissions') }}" method="post">
                        @csrf
                        @method('put')
                        <table class="table table-hover table-admin-cus">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name Admin</th>
                                <th>Name Roles</th>
                                <th>additional permission</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count = 0;
                            ?>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ ++$count }}</td>
                                    <td>{{ $admin->username }}</td>
                                    <td>{{ $admin->getRoleNames()->implode(', ') }}</td>
                                    <td style="width: 50%">
                                        <select style="min-width: 500px" class="select-custom" name="admin-permission[{{$admin->id}}][]" multiple="multiple">
                                            @foreach($permissions as $permission)
                                                @if(!in_array($permission->id, $admin->getPermissionsViaRoles()->pluck('id')->toArray()))
                                                    <option value="{{ $permission->id }}" {{ $admin->hasPermissionTo($permission->id) ? 'selected="selected"' : '' }}>{{ $permission->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div>
                            <button class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
