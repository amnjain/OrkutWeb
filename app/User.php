<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'friend_id',
        'user_id',
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'location',
        'accepted',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    *    Get user name or Full name
    */
    public function getName()
    {
        if($this->first_name && $this->last_name){
            return "{$this->first_name} {$this->last_name}";
        }

        if($this->first_name){
            return $this->first_name;
        }

        return null;
    }

    public function getNameOrUsername()
    {

        if($this->username)
        {
            return $this->getName() ?: $this->username;
        }
    }

    public function getFirstNameOrUsername()
    {
        return $this->first_name ?: $this->username;
    }


    /**
    *    set default avatar
    */
    public function getAvatar()
    {
        //$this = new User();
        $file = $this->avatar;
        //dd($file);
        if($file!='user.jpg')
        {
          return "Uploads/avatars/$file";
        }
        return "https://www.gravatar.com/avatar/{{ md5($this->email) }} ?d=mm&s=40";
    }

    public function likes()
    {
        return $this->hasMany('App\Like', 'user_id');
    }


    public function statuses()
    {
        return $this->hasMany('App\Status', 'user_id');
    }


    public function friendsOfMine()
    {
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendsOf()
    {

        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id');
    }

    /**
    *    check friends of user
    */

    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
                ->merge($this->friendsOf()->wherePivot('accepted', true)->get());
    }

    /**
    *  Send request , accept requests, add new friend
    */

    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    public function friendRequestsPending()
    {
        return $this->friendsOf()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    public function addFriend(User $user)
    {

         $this->friendsOf()->attach($user);
    }

    public function deleteFriend(User $user)
    {
        //$this->friendsOf()->detach($user->id);
        $this->friendsOfMine()->detach($user->id);
    }

    public function acceptFriendRequest(User $user)
    {
         $this->friendRequests()->where('id', $user->id)->first()->pivot
            ->update([
                'accepted'=>true,
        ]);
    }

    public function isFriendsWith(User $user)
    {
        return (bool)$this->friends()->where('id', $user->id)->count();
    }


    public function hasLiked(Status $status)
    {
        return (bool) $status->likes->where('user_id', $this->id)->count();
    }

}
