<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Image;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
    	$user = User::where('username', $username)->first();
    	if(!$user){
    		abort(404);
    	}

        $statuses = $user->statuses()->notReply()->where('user_id', $user->id)->get();
        //dd($statuses);die();

    	return view('profile.index')
                ->with('user', $user)
                ->with('statuses', $statuses)
                ->with('authUserIsFriend', Auth::user()->isFriendsWith($user));
    }

    public function getEdit()
    {
    	return view('profile.edit');

    }

    public function postEdit(Request $request)
    {
    	$this->validate($request, [
    		'first_name' => 'alpha|max:50',
    		'last_name' => 'alpha|max:50',
    		'location' => 'max:25',
     	]);
      //dd($request->hasFile('profile'));
      if($request->hasFile('profile')){
          $avatar = $request->file('profile');
          $filename = time() . '.' . $avatar->getClientOriginalExtension();
          Image::make($avatar)->resize(40, 40)->save('Uploads/avatars/' . $filename );
          $user = Auth::user();
          $user->avatar = $filename;
          $user->first_name = $request->input('first_name');
      		$user->last_name = $request->input('last_name');
      		$user->location = $request->input('location');
          $user->save();
      }


     	return redirect()->route('profile.edit')->with('info', 'Profile updated!');
   	}
}
