@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div class="row">
            <div id="" class="tab-pane fade in active">
                <div style="margin-top: 20px">
                    @if(count($permissions) != 0)
                        <table class="table table-hover table-admin-cus">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Guard Name</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                ?>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ ++$count }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->guard_name }}</td>
                                    <td style="text-align: center">
                                    <span>
                                        <a href="" data-toggle="modal" data-target="#modal-edit-role-{{$permission->name}}"><i
                                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <div style="text-align: left" id="modal-edit-role-{{ $permission->name }}"
                                             class="modal fade @if($errors->first('name-update')) message-error @endif">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.permission.update', ['id' => $permission->id]) }}"
                                                          method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Edit Permission</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group col-sm-12">
                                                                    <label>Permission</label>
                                                                    <input type="text" class="form-control"
                                                                           value="{{ $permission->name }}"
                                                                           name="name-update">
                                                                    @if ($errors->first('name-update'))
                                                                        <span
                                                                            class="register-error-content">{{ $errors->first('name-update') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                    class="btn btn-success">Update</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </span>
                                    <span>
                                        <form action="{{ route('admin.permission.destroy', ['id' => $permission->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                style="border: none; background-color: transparent; margin-left: 5px"
                                                class=""><i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </span>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    @else
                        <h3>No role result</h3>
                    @endif
                </div>
                <button type="button" class="btn btn-info" style="margin-top: 10px" data-toggle="modal"
                        data-target="#modal-add-permission"><i class="fa fa-plus" aria-hidden="true"></i>Add Permission
                </button>
                <div id="modal-add-permission"
                     class="modal fade @if($errors->first('name'))message-error @endif"
                     role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <form action="{{ route('admin.permission.store') }}" method="post">
                                @csrf
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Create Permission</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label>Role</label>
                                            <input type="text" class="form-control"
                                                   value="{{ old('name') ?? old('name') }}"
                                                   name="name">
                                            @if ($errors->first('name'))
                                                <span
                                                    class="register-error-content">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Add</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
