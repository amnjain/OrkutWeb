<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = [
    	'body'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function scopeNotReply($query)
    {
    	return $this->whereNull('parent_id');
    }

    public function replies()
    {
    	return $this->hasMany('App\Status', 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }
}
