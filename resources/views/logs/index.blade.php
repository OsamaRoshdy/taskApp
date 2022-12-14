@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Logs</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Action By</th>
                            <th>Action Type</th>
                            <th>Subject ID</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $typeButtons = [
                                'create' => 'success',
                                'edit' => 'info',
                                'delete' => 'danger',
                            ]
                        @endphp
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->user->username }}</td>
                                <td>
                                    <span class="btn btn-sm btn-{{ $typeButtons[$log->log_type] ?? null }}">
                                        {{ $log->log_type }}
                                    </span>
                                </td>
                                <td>{{ $log->subject_id }}</td>
                                <td>{{ $log->dateHumanize }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin text-center">
                        {{ $logs->links() }}
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
