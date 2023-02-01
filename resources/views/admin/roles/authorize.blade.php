@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div class="row">
            <div class="panel-group" id="accordion">
                <form action="{{ route('admin.role.update_permission') }}" method="post">
                    @csrf
                    @method('put')
                    @foreach($roles as $role)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion"
                                       href="#{{ $role->name }}">{{ $role->name }}</a>
                                </h4>
                            </div>
                            <div id="{{ $role->name }}" class="panel-collapse collapse" style="margin-left: 15px">
                                @foreach($permissions as $permission)
                                    <label style="margin-right: 10px;">
                                        <div style="display: flex; align-items: center">
                                            <input type="checkbox" value="{{ $permission->id }}"
                                                   name="{{ $role->name }}[]" {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <p style="margin-bottom: 0; margin-top: 2px; margin-left: 5px">{{ $permission->name }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <button style="margin-top: 20px" type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
