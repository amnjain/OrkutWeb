
<div class="media">
	<a class="pull-left" href="{{ route('profile.index', ['username'=> $user->username]) }}">
		@php $file = $user->avatar;  @endphp
		<img class="media-object" alt="{{ $user->username }}" src="{{asset('Uploads/avatars').'/'.$file}}">
	</a>
	<div>
		<h4 class="media-heading"><a href="{{ route('profile.index', ['username'=> $user->username]) }}">{{ $user->getNameOrUsername() }}</a></h4>
		@if($user->location)
			<p>{{ $user->location }}</p>
		@endif
	</div>
</div>
