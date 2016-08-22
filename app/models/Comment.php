<?php

class Comment extends Eloquent
{
    protected $fillable = ['id', 'post_id', 'reaction'];

    public function post()
    {
        return $this->belongsTo('Post');
    }
}