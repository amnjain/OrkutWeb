@extends('templates.default')

@section('content')
	<h3>Sign in</h3>
	<div class="row">
		<div class="col-lg-6">
			{{Form::open(['route'=>'auth.signin'])}}
			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				{{Form::label('email', 'E-mail:', ['class'=>'control-label'])}}
				<input type="text" name="email" class="form-control" id="email">
				@if ($errors->has('email'))	
						<span class="help-block">{{ $errors->first('email') }}</span>
				@endif					
			</div>
			<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				{{Form::label('password', 'Password:', ['class'=>'control-label'])}}
				{{Form::password('password',['class'=>'form-control'])}}
				@if ($errors->has('password'))	
						<span class="help-block">{{ $errors->first('password') }}</span>
				@endif			
			</div>	
			<div class="checkbox">
				<label>
					<input type="checkbox" name="remember">Remember me
				</label>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-default">Sign in</button>
			</div>
			{{Form::token()}}
		{{Form::close()}}
		</div>
	</div>
@stop