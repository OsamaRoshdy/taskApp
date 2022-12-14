@extends('layouts.app')
@section('content')
    <div class="col-md-8">
        <div class="form-group">
            <h2>Avatar</h2>
            <img src="{{ $user->avatar }}" alt="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <h2>First Name</h2>
            <p>{{ $user->firstname }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <h2>Last Name</h2>
            <p>{{ $user->lastname }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <h2>Username</h2>
            <p>{{ $user->username }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <h2>Full Name</h2>
            <p>{{ $user->fullname }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <h2>Email</h2>
            <p>{{ $user->email }}</p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <h2>Role</h2>
            <p>{{ $user->role()?->name }}</p>
        </div>
    </div>


@endsection
