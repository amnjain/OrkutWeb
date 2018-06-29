@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-5">
			@include('user.partials.userblock')
			<b><hr></b>

			@if(!$statuses->count())
				<p>{{ $user->getFirstNameOrUsername() }} hasn't posting anything yet!</p>
			@else
				@foreach($statuses as $status)
					@php $file = $status->user->avatar;  @endphp
						<div class="media">
							<a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
								<img class="media-object" alt="{{$status->user->getFirstNameOrUsername()}}" src="{{asset('Uploads/avatars').'/'.$file}}">
							</a>
							<div class="media-body">
								<h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}">{{ $status->user->getFirstNameOrUsername() }}</a></h4>
								<p>{{ $status->body }}</p>
								<ul class="list-inline">
									<li>{{ $status->created_at->diffForHumans() }}</li>
									<li><a href="{{ route('status.like', ['statusId' => $status->id]) }}">Like</a></li>
									<li>{{ $status->likes->count() }} {{ str_plural('Like', $status->likes->count()) }}</li>
								</ul>

								@foreach($status->replies as $reply)
									@php $file = $reply->user->avatar;  @endphp
									<div class="media">
										<a href="{{ route('profile.index', ['username' => $reply->user->username]) }}" class="pull-left">
											<img class="media-object" alt="{{$reply->user->getFirstNameOrUsername()}}" src="{{asset('Uploads/avatars').'/'.$file}}">
										</a>
										<div class="media-body">
											<h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getFirstNameOrUsername() }}</a></h5>
											<p>{{ $reply->body }}</p>
											<ul class="list-inline">
												<li>{{$reply->created_at->diffForHumans()}}</li>
												<li><a href="{{ route('status.like', ['statusId' => $reply->id]) }}">Like</a></li>
												<li>{{ $reply->likes->count() }} {{ str_plural('Like', $reply->likes->count()) }}</li>
											</ul>
										</div>
									</div>
								@endforeach

								@if($authUserIsFriend || Auth::user()->id === $status->user->id)
									<form role="form" action="{{ route('status.reply', ['statusId' =>$status->id]) }}" method="post">
										<div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error': '' }}">
											<textarea name="reply-{{ $status->id }}" class="form-control" rows="3" placeholder="Reply to this.."></textarea>
											@if ($errors->has("reply-{$status->id}"))
												<span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
											@endif
										</div>
											<input type="submit" value="Reply" class="btn btn-default btn-sm">
											{{Form::token()}}
									</form>
								@endif
							</div>
						</div>

				@endforeach
			@endif
		</div>
		<div class="col-lg-4 col-lg-offset-3">
			@if(Auth::user()->hasFriendRequestPending($user))
				<p>Waiting for {{ $user->getNameOrUsername() }} to accept your request!</p>

			@elseif (Auth::user()->hasFriendRequestReceived($user))
				<a href="{{ route('friend.accept', ['username'=>$user->username]) }}" class="btn btn-primary">Accept</a>

			@elseif(Auth::user()->isFriendsWith($user))
				<p>You and {{ $user->getNameOrUsername() }} are friends.</p>
				<form action="{{ route('friend.delete', ['username' => $user->username]) }}" method="post">
					<button class="btn btn-primary">Delete Friend</button>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>
			@elseif(Auth::user()->id!==$user->id)
				<a href="{{ route('friend.add', ['username'=>$user->username]) }}" class="btn btn-primary">Add Friend</a>
			@endif


			<h4>{{ $user->getFirstNameOrUsername() }}'s friends</h4>
			@if($user->friends()->count()==0)
				<p>{{ $user->getFirstNameOrUsername() }} has no friends!</p>

			@else
				@foreach($user->friends() as $user )
					@include('user.partials.userblock')
				@endforeach
			@endif

		</div>
	</div>

@stop
