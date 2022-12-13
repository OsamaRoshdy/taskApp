<div class="col-md-6">
    <div class="form-group">
        {{ Form::label('firstname', 'First Name') }}
        {{ Form::text('firstname', old('firstname'), ['class' => 'form-control']) }}
        @if($errors->has('firstname'))
            <div class="text-red">{{ $errors->first('firstname') }}</div>
        @endif
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {{ Form::label('lastname', 'Last Name') }}
        {{ Form::text('lastname', old('lastname'), ['class' => 'form-control']) }}
        @if($errors->has('lastname'))
            <div class="text-red">{{ $errors->first('lastname') }}</div>
        @endif
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {{ Form::label('username', 'Username') }}
        {{ Form::text('username', old('username'), ['class' => 'form-control']) }}
        @if($errors->has('username'))
            <div class="text-red">{{ $errors->first('username') }}</div>
        @endif
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {{ Form::label('email', 'Email') }}
        {{ Form::email('email', old('email'), ['class' => 'form-control']) }}
        @if($errors->has('email'))
            <div class="text-red">{{ $errors->first('email') }}</div>
        @endif
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {{ Form::label('password', 'Password') }}
        {{ Form::password('password', ['class' => 'form-control']) }}
        @if($errors->has('password'))
            <div class="text-red">{{ $errors->first('password') }}</div>
        @endif
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {{ Form::label('password_confirmation', 'Password Confirmation') }}
        {{ Form::password('password_confirmation',  ['class' => 'form-control']) }}
        @if($errors->has('password_confirmation'))
            <div class="text-red">{{ $errors->first('password_confirmation') }}</div>
        @endif
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {{ Form::label('roles', 'Role') }}
        {{ Form::select('roles',$roles,old('roles'), ['class' => 'form-control']) }}
        @if($errors->has('roles'))
            <div class="text-red">{{ $errors->first('photo') }}</div>
        @endif
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {{ Form::label('photo', 'Photo') }}
        {{ Form::file('photo', ['class' => 'form-control']) }}
        @if($errors->has('photo'))
            <div class="text-red">{{ $errors->first('photo') }}</div>
        @endif
    </div>
</div>
