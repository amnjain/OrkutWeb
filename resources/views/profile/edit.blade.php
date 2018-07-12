@extends('templates.default')

@section('content')
	<h3>Update your profile</h3>
	<div class="row">
		<div class="col-lg-6">
			{{Form::open(['route' => 'profile.edit', 'files' => true]) }}
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
							{{Form::label('first_name','First Name', ['class'=>'control-label','required'])}}
							{{Form::text('first_name','', ['class'=>'form-control', 'required'])}}
							@if ($errors->has('first_name'))
								<span class="help-block">{{ $errors->first('first_name') }}</span>
							@endif
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
							{{Form::label('last_name','Last Name', ['class'=>'control-label'])}}
							{{Form::text('last_name','', ['class'=>'form-control', 'required'])}}
							@if ($errors->has('last_name'))
								<span class="help-block">{{ $errors->first('last_name') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="form-group">
					{{Form::label('profile','Upload Profile', ['class'=>'control-label', 'required'])}}
					{{Form::file('profile',['class'=>'form-control', 'required'])}}
				</div>
				<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
					{{Form::label('location','Location', ['class'=>'control-label'])}}
					{{Form::text('location','', ['class'=>'form-control'])}}
					@if ($errors->has('location'))
						<span class="help-block">{{ $errors->first('location') }}</span>
					@endif
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-default">Update</button>
				</div>
			{{Form::close()}}
		</div>
	</div>
@stop
