@extends('layouts.app')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Quick Example</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {{ Form::open(['route' => 'users.store', 'role' => 'form', 'files' => true]) }}
            <div class="box-body">
                <div class="row">
                    @include('users.form')
                </div>
            </div>

            <div class="box-footer">
                {{ Form::submit('Submit' , ['class' => 'btn btn-primary']) }}
            </div>
        {{ Form::close() }}
    </div>
@endsection
