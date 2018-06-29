<!DOCTYPE html>
<html lang="en">
<head>
  <title>Orkut</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style >
    .navbar-inverse .navbar-nav>li>a {
      color: #ece7e7;
    }
    .footer {
    position: relative;
    height: 30px;
    bottom: 0;
    width: 100%;
    text-align: center;
  }

  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('home') }}">Orkut</a>
    </div>
   @if (Auth::check())
    <ul class="nav navbar-nav">
      <li class="active"><a href="{{ route('home') }}">Timeline</a></li>
      <li class="active"><a href="{{ route('friend.index') }}">Friends</a></li>
       <form class="navbar-form navbar-left" role="search" action="{{ route('search.results') }}">
        <div class="form-group">
          <input type="text" name="query" class="form-control" placeholder="Find People">
        </div>
        <button type="submit" class="btn btn-default">Search</button>
      </form>
    </ul>

    @endif

    <ul class="nav navbar-nav navbar-right">
      @if(Auth::check())
        <li><a href="{{ route('profile.index', ['username' => Auth::user()->username]) }}">{{ Auth::user()->getNameOrUsername() }}</a></li>
        <li><a href="{{ route('profile.edit') }}">Update profile</a></li>
        <li><a href="/signout">Sign Out</a></li>
      @else
        <li><a href="/signup"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="/signin"><span class="glyphicon glyphicon-log-in"></span> Sign in</a></li>
      @endif
    </ul>
  </div>
</nav>

</body>
</html>
	<div class="container">
		@include('templates.partials.alerts')
		@yield('content')

	</div>
  <div class="footer">© 2018 Copyright
    <a href="https://orkutweb.herokuapp.com/"> OrkutWeb</a>
  </div>
