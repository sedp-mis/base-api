<?php

use SedpMis\BaseRepository\ValidatingTrait;

class Comment extends Eloquent
{
    use ValidatingTrait;
    
    protected $fillable = ['id', 'post_id', 'reaction'];

    public function post()
    {
        return $this->belongsTo('Post');
    }
}