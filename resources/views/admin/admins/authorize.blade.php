@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div class="row">
            <div class="tab-pane fade in active">
                <div style="margin-top: 20px">
                    <form action="{{ route('admin.update_roles') }}" method="post">
                        @csrf
                        @method('put')
                        <table class="table table-hover table-admin-cus">
                            <thead>
                            <tr>
                                <th>Admin</th>
                                <th>Roles</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($admins as $admin)
                                <tr>
                                    <td style="width: 20%">{{ $admin->username }}</td>
                                    <td style="width: 80%">
                                        <select style="width: 100%" class="select-custom" name="roles-admin[{{ $admin->id }}][]"
                                                multiple="multiple">
                                            @foreach($roles as $role)
                                                <option
                                                    {{ in_array($role->id, $admin->roles->pluck('id')->toArray()) ? 'selected="selected"' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
                {{ $admins->links('admin.layouts.pagination') }}
            </div>
        </div>
    </div>
@endsection
