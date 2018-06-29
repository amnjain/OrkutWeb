@extends('templates.default')

@section('content')
	<h3>Sign Up</h3>
	<div class="row">
		<div class="col-lg-6">

			{{Form::open(['route'=> 'auth.signup'])}}
				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					{{Form::label('email', 'E-mail:',['class'=>'control-label'])}}
					<input type="text" name="email" class="form-control" id="email" value=" {{Request::old('email') ?: '' }} ">
					@if ($errors->has('email'))
						<span class="help-block">{{ $errors->first('email') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
					{{Form::label('username', 'Username',['class'=>'control-label'])}}
					<input type="text" name="username" class="form-control" id="username" value=" {{Request::old('username') ?: '' }} ">
					@if ($errors->has('username'))
						<span class="help-block">{{ $errors->first('username') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					{{Form::label('password', 'Password', ['class'=>'control-label'])}}
					{{Form::password('password', ['class' => 'form-control'])}}
					@if ($errors->has('password'))
						<span class="help-block">{{ $errors->first('password') }}</span>
					@endif
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-default">Sign Up</button>
				</div>
				{{Form::token()}}
			{{Form::close()}}
		</div>
	</div>
@stop
