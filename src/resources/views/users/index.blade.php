@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Users</h3>

                    <div class="box-tools">
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Create</a>
                        <a href="{{ route('users.trashed') }}" class="btn btn-sm btn-danger">Trashed</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Avatar</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->fullname }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><img width="35px" src="{{ $user->avatar }}"></td>
                                    <td>
                                        <div class="btn-group">
                                            {{ Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) }}
                                            <a class="btn btn-sm btn-success" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                            <a class="btn btn-sm btn-info" href="{{ route('users.show', $user->id) }}">Show</a>
                                            @if(auth()->user()->hasRole('admin'))
                                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                            @endif
                                            {{ Form::close() }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin text-center">
                        {{ $users->links() }}
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
