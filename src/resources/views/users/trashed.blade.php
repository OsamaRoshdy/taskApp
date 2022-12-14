@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Users</h3>

                    <div class="box-tools">
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">All</a>
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
                            <th>Restore</th>
                            <th>Force Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="btn-group">
                                        {{ Form::open(['route' => ['users.restore', $user->id], 'method' => 'PATCH']) }}
                                        <button class="btn btn-sm btn-success" type="submit">Restore</button>
                                        {{ Form::close() }}
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        {{ Form::open(['route' => ['users.delete', $user->id], 'method' => 'DELETE']) }}
                                        <button class="btn btn-sm btn-danger" type="submit">Force Delete</button>
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
