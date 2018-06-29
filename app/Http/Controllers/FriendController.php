<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\User;

class FriendController extends Controller
{
	public function getIndex()
	{
	
		$friends = Auth::user()->friends();
		$requests = Auth::user()->friendRequests();
		return view('friend.index')
				->with('friends', $friends)
				->with('requests', $requests);
	}

	public function getAdd($username)
	{
		$user = User::where('username', $username)->first();

		if($user->count()==0)
		{
			return redirect()
					->route('home')
					->with('User could not be found');
		}

		if(Auth::user()->id===$user->id)
		{
			return redirect()->route('home');
		}

		if(Auth::user()->hasFriendRequestPending($user) )
		{
			return redirect()
					->route('profile.index',['username'=>$user->username])
					->with('info', 'Friend Request already send');
		}

		if(Auth::user()->isFriendsWith($user))
		{
			return redirect()
					->route('profile.index',['username'=>$user->username])
					->with('info', 'You are already friends');
		}

		Auth::user()->addFriend($user);

		return redirect()
				->route('profile.index',['username'=>$username])
				->with('info', 'Friend Request sent!');
	}


	public function getAccept($username)
	{
		$user = User::where('username', $username)->first();

		if($user->count()==0)
		{
			return redirect()
					->route('home')
					->with('User could not be found');
		}

		if(!Auth::user()->hasFriendRequestReceived($user)){
			return redirect()->route('home');
		}

		Auth::user()->acceptFriendRequest($user);

		return redirect()->route('profile.index',['username'=>$username])
							->with('info', 'Friend request accepted!');
	}


	public function postDelete($username)
	{
			$user = User::where('username', $username)->first();

			if(!Auth::user()->isFriendsWith($user)){
				return redirect()->back();
			}


			Auth::user()->deleteFriend($user);

			return redirect()->back()->with('info', 'Friend deleted');

	}
}
