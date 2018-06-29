@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<h3>Your Friends</h3>
			@if($friends->count()==0)
				<p>You have no friends!!</p>

			@else
				@foreach($friends as $user )
					@include('user.partials.userblock')
				@endforeach
			@endif

		</div>
		<div>
			<h4>Friend Requests</h4>
			@if($requests->count()==0)
				<p>You have no friend requests!</p>
			@else
				@foreach($requests as $user)
					@include('user.partials.userblock')
				@endforeach
			@endif
			
		</div>
	</div>
@stop