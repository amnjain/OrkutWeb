@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<form role='form' action="{{ route('status.post') }}" method="post">
				<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
					<textarea placeholder="What's up {{ Auth::user()->getFirstNameOrUsername() }}?"" name="status" class="form-control" rows="4"></textarea>
					@if ($errors->has('status'))
						<span class="help-block">{{ $errors->first('status') }}</span>
					@endif
				</div>
				<button type="submit" class="btn btn-default">Update status</button>
				{{Form::token()}}
			</form>
				<hr>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-5">
			@if(!$statuses->count())
				<p>There's nothing in your timeline!</p>
			@else
				@foreach($statuses as $status)
						@php $file = $status->user->avatar;@endphp
					<div class="media">
						<a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
							<img class="media-object" alt="{{$status->user->getFirstNameOrUsername()}}" src="Uploads/avatars/<?= $file ?>">
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
								@php $file = $reply->user->avatar;@endphp
								<div class="media">
									<a href="{{ route('profile.index', ['username' => $reply->user->username]) }}" class="pull-left">

										<img class="media-object" alt="{{$reply->user->getFirstNameOrUsername()}}" src="Uploads/avatars/<?= $file ?>">
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
						</div>
					</div>
				@endforeach

				{!! $statuses->render() !!}
			@endif
		</div>
	</div>
@stop
