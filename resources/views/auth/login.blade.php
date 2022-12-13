@include('layouts.head')
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b>LTE</a>
    </div>
    <div class="login-box-body">

        <p class="login-box-msg">Sign in to start your session</p>

        {{ Form::open(['route' => 'login']) }}
            <div class="form-group has-feedback">
                {{ Form::email('email', old('email'), ['placeholder' => 'Email', 'class' => 'form-control']) }}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {{ Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) }}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        {{ Form::close() }}

    </div>
</div>
@include('layouts.footer')
